<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Navigation\NavigationGroup;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->brandLogo(asset('assets/ic_edu_logo.png'))
            ->brandLogoHeight('2.5rem')
            ->login()
            ->databaseNotifications()
            ->databaseNotificationsPolling('30s')
            ->font('Inter')
            ->colors([
                'primary' => Color::Blue,
                'gray' => Color::Slate,
            ])
            ->sidebarCollapsibleOnDesktop()
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Operations')
                    ->collapsible(false),
                NavigationGroup::make()
                    ->label('Course Management')
                    ->collapsible(false),
                NavigationGroup::make()
                    ->label('Exam Management')
                    ->collapsible(false),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->pages([
                \App\Filament\Pages\Dashboard::class,
            ])
            ->widgets([
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->renderHook(
                'panels::head.end',
                fn () => new \Illuminate\Support\HtmlString(
                    '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="anonymous"/>' .
                    '<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin="anonymous"></script>' .
                    '<style>
                        /* Topbar Glassmorphism */
                        .fi-topbar { background: rgba(255, 255, 255, 0.7) !important; backdrop-filter: blur(12px) !important; -webkit-backdrop-filter: blur(12px) !important; border-bottom: 1px solid rgba(0,0,0,0.05); }
                        .dark .fi-topbar { background: rgba(15, 23, 42, 0.7) !important; border-bottom: 1px solid rgba(255,255,255,0.05); }
                        
                        /* Table Rows Micro-Animation */
                        .fi-ta-row { transition: all 0.2s ease-in-out; }
                        .fi-ta-row:hover { transform: scale(1.005); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05); z-index: 10; position: relative; border-radius: 0.5rem; }
                        
                        /* Buttons Micro-Animation */
                        .fi-btn { transition: all 0.2s ease; }
                        .fi-btn:hover { transform: translateY(-1px); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
                        .fi-btn:active { transform: translateY(0); }
                        
                        /* Widget Cards Hover Effect */
                        .fi-wi-stats-overview-stat { transition: all 0.3s ease; border: 1px solid transparent; }
                        .fi-wi-stats-overview-stat:hover { transform: translateY(-3px); border-color: rgba(59, 130, 246, 0.3); box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.1); }
                        
                        /* Custom scrollbar for better aesthetics */
                        ::-webkit-scrollbar { width: 6px; height: 6px; }
                        ::-webkit-scrollbar-track { background: transparent; }
                        ::-webkit-scrollbar-thumb { background: rgba(156, 163, 175, 0.5); border-radius: 10px; }
                        ::-webkit-scrollbar-thumb:hover { background: rgba(107, 114, 128, 0.8); }
                    </style>'
                )
            );
    }
}
