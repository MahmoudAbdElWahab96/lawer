<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\Stats;
use App\Http\Middleware\SetAdminLocale;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    /**
     * Bilingual fields always type in their content's direction, whatever the panel language is.
     */
    public function boot(): void
    {
        $alignToContentLanguage = function (TextInput|Textarea $field): void {
            $name = $field->getName();

            if (str_ends_with($name, '.ar') || str_ends_with($name, '.en')) {
                $field->extraInputAttributes(['dir' => str_ends_with($name, '.ar') ? 'rtl' : 'ltr']);
            }
        };

        TextInput::configureUsing($alignToContentLanguage);
        Textarea::configureUsing($alignToContentLanguage);
    }

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->favicon(asset('favicon-32.png').'?v=2')
            ->path('admin')
            ->login()
            ->brandName(fn (): string => __('إدارة الموقع'))
            ->font(fn (): string => app()->getLocale() === 'ar' ? 'Noto Sans Arabic' : 'Inter')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                Stats::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->middleware([
                SetAdminLocale::class,
            ], isPersistent: true)
            ->renderHook(PanelsRenderHook::USER_MENU_BEFORE, fn (): View => view('filament.hooks.language-switch'))
            ->renderHook(PanelsRenderHook::AUTH_LOGIN_FORM_BEFORE, fn (): View => view('filament.hooks.language-switch'))
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
