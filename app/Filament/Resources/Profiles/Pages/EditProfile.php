<?php

namespace App\Filament\Resources\Profiles\Pages;

use App\Filament\Resources\Profiles\ProfileResource;
use App\Models\Language;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\App;

class EditProfile extends EditRecord
{
    protected static string $resource = ProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label(__('Download CV (PDF)'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    // 1. Carrega o registro do perfil atual com os relacionamentos carregados
                    $profile = $this->getRecord()->load(['user', 'skills', 'academics', 'experiences', 'languages', 'city', 'state']);

                    // 2. Resolve dinamicamente a linguagem salva no banco
                    // Supondo que você salve o ID ou a sigla 'pt', 'en' no campo lang.
                    $languageModel = Language::find($profile->lang);

                    // Ajuste aqui com base no formato real da sua tabela de idiomas (ex: 'en', 'pt', 'fr')
                    $langCode = $languageModel ? strtolower($languageModel->sigla_ou_code ?? 'pt-BR') : 'pt-BR';

                    // 3. Altera o Locale da aplicação em Runtime antes de renderizar a view do DomPDF
                    App::setLocale($langCode);

                    // 4. Prepara e gera o PDF passando as variáveis necessárias
                    $pdf = Pdf::loadView('pdf.cv', [
                        'profile' => $profile,
                        'langCode' => $langCode
                    ])
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);

                    // 5. Retorna o stream de download com nome limpo e adaptado
                    $filename = str($profile->user->name . ' - CV - ' . $profile->title)
                        ->slug()
                        ->append('.pdf')
                        ->toString();

                    return response()->streamDownload(function () use ($pdf) {
                        echo $pdf->output();
                    }, $filename);
                }),

            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return parent::getResourceUrl('index');
    }
}
