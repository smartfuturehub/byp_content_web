<?php

namespace App\Filament\Forms;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichEditorTool;
use Filament\Support\Icons\Heroicon;

class CmsRichEditor extends RichEditor
{
    /**
     * Images attached in the body go where every other CMS upload goes, rather
     * than to Filament's default `public` disk, which this app never links.
     */
    public const IMAGE_DISK = AttachFilesAction::PDF_DISK;

    public const IMAGE_DIRECTORY = 'uploads/images';

    protected function setUp(): void
    {
        parent::setUp();

        // Embeds live in a custom block: their markup would not survive the
        // editor's document schema. See EmbedBlock.
        $this->customBlocks([
            EmbedBlock::class,
        ]);

        $this->fileAttachmentsDisk(self::IMAGE_DISK)
            ->fileAttachmentsDirectory(self::IMAGE_DIRECTORY)
            ->fileAttachmentsVisibility('public')
            // Stored as a root-relative path, the way the PDF links are, so the
            // body survives a move between the local and the live domain.
            ->getFileAttachmentUrlUsing(static function (mixed $file, RichEditor $component): ?string {
                if (! is_string($file) || blank($file)) {
                    return null;
                }

                // Filament reads a null back as "that attachment is gone", so
                // the file still has to be checked for before building the URL.
                if (! $component->getFileAttachmentsDisk()->exists($file)) {
                    return null;
                }

                return '/'.ltrim($file, '/');
            });

        // Relabels the toolbar button Filament registers as `attachFiles`, so the
        // tooltip says what it now accepts.
        $this->tools([
            RichEditorTool::make('attachFiles')
                ->label('Attach image or PDF')
                ->action(arguments: '{ alt: $getEditor().getAttributes(\'image\')?.alt, id: $getEditor().getAttributes(\'image\')?.id, src: $getEditor().getAttributes(\'image\')?.src }')
                ->activeKey('image')
                ->icon(Heroicon::PaperClip)
                ->iconAlias('forms:components.rich-editor.toolbar.attach-files'),
        ]);

        $this->registerActions([
            AttachFilesAction::make(),
        ]);
    }
}
