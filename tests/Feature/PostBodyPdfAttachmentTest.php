<?php

namespace Tests\Feature;

use App\Filament\Forms\AttachFilesAction;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class PostBodyPdfAttachmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The selection the editor sends along with every toolbar action.
     *
     * @var array<string, mixed>
     */
    private const EDITOR_SELECTION = ['editorSelection' => ['type' => 'text', 'anchor' => 1, 'head' => 1]];

    public function test_the_post_body_attach_button_says_it_takes_pdfs(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        $this->actingAs($admin)
            ->get('/admin/posts/create')
            ->assertOk()
            ->assertSee('Attach image or PDF');
    }

    public function test_attaching_a_pdf_inserts_a_link_into_the_post_body(): void
    {
        $this->seed();

        Storage::fake(AttachFilesAction::PDF_DISK);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(CreatePost::class)
            ->callAction(
                TestAction::make('attachFiles')->schemaComponent('body')->arguments(self::EDITOR_SELECTION),
                [
                    'file' => UploadedFile::fake()->create('brochure.pdf', 120, AttachFilesAction::PDF_MIME_TYPE),
                    'alt' => 'Download the brochure',
                ],
            )
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $event, array $params): bool {
                $link = $params['commands'][0]['arguments'][0][0] ?? [];
                $href = $link['marks'][0]['attrs']['href'] ?? '';

                return $link['text'] === 'Download the brochure'
                    && str_starts_with($href, '/'.AttachFilesAction::PDF_DIRECTORY.'/')
                    && str_ends_with($href, '.pdf');
            });

        $this->assertCount(1, Storage::disk(AttachFilesAction::PDF_DISK)->files(AttachFilesAction::PDF_DIRECTORY));
    }

    public function test_a_pdf_without_a_label_falls_back_to_its_file_name(): void
    {
        $this->seed();

        Storage::fake(AttachFilesAction::PDF_DISK);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(CreatePost::class)
            ->callAction(
                TestAction::make('attachFiles')->schemaComponent('body')->arguments(self::EDITOR_SELECTION),
                ['file' => UploadedFile::fake()->create('brochure.pdf', 120, AttachFilesAction::PDF_MIME_TYPE)],
            )
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $event, array $params): bool {
                return ($params['commands'][0]['arguments'][0][0]['text'] ?? null) === 'brochure.pdf';
            });
    }

    public function test_attaching_an_image_still_inserts_an_image(): void
    {
        $this->seed();

        Storage::fake(AttachFilesAction::PDF_DISK);

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(CreatePost::class)
            ->callAction(
                TestAction::make('attachFiles')->schemaComponent('body')->arguments(self::EDITOR_SELECTION),
                [
                    'file' => UploadedFile::fake()->image('diagram.png'),
                    'alt' => 'A diagram',
                ],
            )
            ->assertHasNoActionErrors()
            ->assertDispatched('run-rich-editor-commands', function (string $event, array $params): bool {
                $node = $params['commands'][0]['arguments'][0] ?? [];

                return ($node['type'] ?? null) === 'image'
                    && ($node['attrs']['alt'] ?? null) === 'A diagram';
            });
    }

    public function test_other_file_types_are_still_rejected(): void
    {
        $this->seed();

        $admin = User::query()->where('email', 'admin@byphealthtek.com')->first();

        Livewire::actingAs($admin)
            ->test(CreatePost::class)
            ->callAction(
                TestAction::make('attachFiles')->schemaComponent('body')->arguments(self::EDITOR_SELECTION),
                ['file' => UploadedFile::fake()->create('notes.txt', 10, 'text/plain')],
            )
            ->assertHasActionErrors(['file']);
    }
}
