<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Resources\Bukus\BukuResource;
use App\Filament\Resources\Admin\BookReservations\BookReservationResource;
use App\Filament\Resources\Admin\BookReviews\BookReviewResource;
use App\Filament\Resources\Admin\Users\UserResource;
use App\Filament\Resources\Admin\Members\MemberResource;
use App\Filament\Resources\Admin\Notifications\NotificationResource;
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
            ->brandName('Admin Panel - Dinas Arsip dan Perpustakaan Provinsi Papua')
            ->default()
            ->sidebarFullyCollapsibleOnDesktop()
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                BookReservationResource::class,
                BookReviewResource::class,
                NotificationResource::class,
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
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.users.*')),

                            NavigationItem::make('Members')
                                ->icon('heroicon-o-user-group')
                                ->visible(Auth::user()->role === 'admin')
                                ->url(MemberResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.members.*')),

                            NavigationItem::make('Books')
                                ->icon('heroicon-o-book-open')
                                ->url(BukuResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.bukus.*')),

                            NavigationItem::make('Categories')
                                ->icon('heroicon-o-tag')
                                ->url(CategoryResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.categories.*')),
                        ]),

                    NavigationGroup::make('Peminjaman')
                        ->items([
                            NavigationItem::make('Peminjaman')
                                ->icon('heroicon-o-document-text')
                                ->url(PinjamanResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.pinjamen.*')),

                            NavigationItem::make('Reservasi Buku')
                                ->icon('heroicon-o-calendar-days')
                                ->url(BookReservationResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.book-reservations.*')),

                            NavigationItem::make('Denda & Sanksi')
                                ->icon('heroicon-o-exclamation-triangle')
                                ->visible(Auth::user()->role === 'admin')
                                ->url(PaymentsResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.payments.*')),
                        ]),

                    NavigationGroup::make('Komunitas')
                        ->items([
                            NavigationItem::make('Ulasan Buku')
                                ->icon('heroicon-o-star')
                                ->url(BookReviewResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.book-reviews.*')),

                            NavigationItem::make('Notifikasi')
                                ->icon('heroicon-o-bell')
                                ->url(NotificationResource::getUrl())
                                ->visible(Auth::user()->role === 'admin')
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.notifications.*')),
                        ]),

                    NavigationGroup::make('Reports')
                        ->items([
                            NavigationItem::make('Laporan')
                                ->icon('heroicon-o-chart-bar')
                                ->url(ReportResource::getUrl())
                                ->isActiveWhen(fn() => request()->routeIs('filament.admin.resources.admin.reports.*')),
                        ]),
                ]);
            })
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}