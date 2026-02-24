<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\Bukus\BukuResource;
use App\Filament\Resources\Admin\Users\UserResource;
use App\Filament\Resources\Admin\Members\MemberResource;
use App\Filament\Resources\Admin\Payments\PaymentsResource;
use App\Filament\Resources\Admin\Pinjamen\PinjamanResource;
use App\Filament\Resources\Admin\Categories\CategoryResource;
use App\Filament\Resources\Admin\Reports\ReportResource;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationBuilder;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('admin')
            ->path('app')
            ->colors([
                'primary' => Color::Amber,
            ])
            // ->brandLogo(asset('favicon_io/android-chrome-512x512.png'))
            ->brandName('Admin Panel - Dinas Arsip dan Perpustakaan Provinsi Papua')
            ->default()
            ->sidebarFullyCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->resources([
                UserResource::class,
                BukuResource::class,
                MemberResource::class,
                PaymentsResource::class,
                PinjamanResource::class,
                CategoryResource::class,
                ReportResource::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
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
            ->navigation(function (NavigationBuilder $builder) {
                return $builder->groups([
                    NavigationGroup::make('Dashboard')
                        ->items([
                            NavigationItem::make('Dashboard')
                                ->icon('heroicon-o-home')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.pages.dashboard'))
                                ->url(fn() => Dashboard::getUrl()),
                        ]),

                    NavigationGroup::make('Management')
                        ->items([
                            NavigationItem::make('Users')
                                ->icon('heroicon-o-users')
                                ->visible(Auth::user()->role === 'admin')
                                ->url(UserResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.users.index')),

                            NavigationItem::make('Members')
                                ->icon('heroicon-o-user-group')
                                ->visible(Auth::user()->role === 'admin')
                                ->url(MemberResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.members.index')),

                            NavigationItem::make('Books')
                                ->icon('heroicon-o-book-open')
                                ->url(BukuResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.bukus.index')),

                            NavigationItem::make('Categories')
                                ->icon('heroicon-o-tag')
                                ->url(CategoryResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.categories.index')),
                        ]),

                    NavigationGroup::make('Peminjaman')
                        ->items([
                            NavigationItem::make('Peminjaman')
                                ->icon('heroicon-o-document-text')
                                ->url(PinjamanResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.pinjamen.index')),

                            NavigationItem::make('Denda & Sanksi')
                                ->icon('heroicon-o-exclamation-triangle')
                                ->visible(Auth::user()->role === 'admin')
                                ->url(PaymentsResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.payments.index')),
                        ]),

                    NavigationGroup::make('Reports')
                        ->items([
                            NavigationItem::make('Reports')
                                ->icon('heroicon-o-chart-bar')
                                ->url(ReportResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.reports.index')),
                        ]),
                ]);
            })
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}