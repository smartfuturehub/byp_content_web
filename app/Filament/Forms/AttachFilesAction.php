<?php

namespace App\Filament\Forms;

use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\Actions\AttachFilesAction as BaseAttachFilesAction;
use Filament\Forms\Components\RichEditor\EditorCommand;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

/**
 * The attach button in the rich editor, widened to take PDFs as well as images.
 *
 * Images keep Filament's own behaviour — they are inserted as image nodes. A PDF
 * cannot be, so it is stored alongside the other CMS uploads and inserted as a
 * link instead.
 */
class AttachFilesAction
{
    public const PDF_MIME_TYPE = 'application/pdf';

    public const PDF_DISK = 'public_web';

    public const PDF_DIRECTORY = 'uploads/documents';

    public static function make(): Action
    {
        $action = BaseAttachFilesAction::make();
        $attachImage = $action->getActionFunction();

        return $action
            ->schema(fn (array $arguments, RichEditor $component): array => [
                FileUpload::make('file')
                    ->label(filled($arguments['src'] ?? null)
                        ? __('filament-forms::components.rich_editor.actions.attach_files.modal.form.file.label.existing')
                        : __('filament-forms::components.rich_editor.actions.attach_files.modal.form.file.label.new'))
                    ->acceptedFileTypes([
                        ...$component->getFileAttachmentsAcceptedFileTypes() ?? [],
                        self::PDF_MIME_TYPE,
                    ])
                    ->maxSize($component->getFileAttachmentsMaxSize())
                    ->storeFiles(false)
                    ->required(blank($arguments['src'] ?? null))
                    ->hiddenLabel(blank($arguments['src'] ?? null)),
                TextInput::make('alt')
                    ->label(filled($arguments['src'] ?? null)
                        ? __('filament-forms::components.rich_editor.actions.attach_files.modal.form.alt.label.existing')
                        : __('filament-forms::components.rich_editor.actions.attach_files.modal.form.alt.label.new'))
                    ->helperText('Describes an image, or labels the link for a PDF. PDFs fall back to the file name.')
                    ->maxLength(1000),
            ])
            ->action(function (Action $action, array $arguments, array $data, RichEditor $component) use ($attachImage): void {
                $file = $data['file'] ?? null;

                if (! ($file instanceof TemporaryUploadedFile) || $file->getMimeType() !== self::PDF_MIME_TYPE) {
                    $action->evaluate($attachImage);

                    return;
                }

                $path = $file->storeAs(
                    self::PDF_DIRECTORY,
                    Str::ulid().'.'.($file->getClientOriginalExtension() ?: 'pdf'),
                    self::PDF_DISK,
                );

                $component->runCommands(
                    [
                        EditorCommand::make('insertContent', arguments: [[
                            [
                                'type' => 'text',
                                'text' => filled($data['alt'] ?? null) ? $data['alt'] : $file->getClientOriginalName(),
                                'marks' => [[
                                    'type' => 'link',
                                    'attrs' => [
                                        'href' => '/'.ltrim($path, '/'),
                                        'target' => '_blank',
                                    ],
                                ]],
                            ],
                            ['type' => 'text', 'text' => ' '],
                        ]]),
                    ],
                    editorSelection: $arguments['editorSelection'] ?? null,
                );
            });
    }
}
