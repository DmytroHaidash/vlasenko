<?php

namespace App\Services;

use App\Models\Catalog\Order;
use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use Illuminate\Support\Facades\Auth;
use Talanoff\ImpressionAdmin\Elements\NavigationElement;

class Navigation
{
    public function frontend()
    {
        $questionary = [];

        $items = [
            (object)[
                'name' => trans('navigation.header.catalog'),
                'route' => route('app.catalog.index'),
            ],
            (object)[
                'name' => trans('navigation.header.about'),
                'route' => url('/about'),
            ],
            (object)[
                'name' => trans('navigation.header.warranty'),
                'route' => url('/payment-and-delivery')
            ],
            (object)[
                'name' => trans('navigation.header.contacts'),
                'route' => url('/contacts'),
            ],
            (object)[
                'name' => trans('navigation.header.articles'),
                'route' => url('/articles'),
            ],
        ];

        if (Auth::check() && Question::count()) {
            $questionary = [
                (object)[
                    'name' => trans('navigation.header.questionary'),
                    'route' => route('app.questionary.index')
                ]
            ];
        }

        return array_merge($items, $questionary);
    }

    public function frontendFooter()
    {
        $questionary = [];

        $items = [
            (object)[
                'name' => trans('navigation.header.catalog'),
                'route' => route('app.catalog.index'),
            ],
            (object)[
                'name' => trans('navigation.header.about'),
                'route' => url('/about'),
            ],
            (object)[
                'name' => trans('navigation.header.contacts'),
                'route' => url('/contacts'),
            ],
            (object)[
                'name' => trans('navigation.header.warranty'),
                'route' => url('/payment-and-delivery')
            ],
            (object)[
                'name' => trans('navigation.header.terms'),
                'route' => url('terms-and-conditions')
            ]
        ];

        if (Auth::check() && Question::count()) {
            $questionary = [
                (object)[
                    'name' => trans('navigation.header.questionary'),
                    'route' => route('app.questionary.index')
                ]
            ];
        }

        return array_merge($items, $questionary);
    }

    public function backend()
    {
        $items = [
            new NavigationElement([
                'name' => '????????????',
                'route' => 'orders',
                'icon' => 'i-wallet',
                'submenu' => null,
                'unread' => Order::whereIn('status', ['processing', 'no_dial'])->count(),
            ]),
            new NavigationElement([
                'name' => '????????????',
                'route' => 'question',
                'icon' => 'i-book',
                'compare' => ['questions', 'answers'],
                'unread' => Answer::where('status', ['processing'])->count(),
                'submenu' => [
                    'questions' => [
                        'name' => '??????????????',
                        'route' => 'admin.questions.index',
                    ],
                    'answers' => [
                        'name' => '????????????',
                        'route' => 'admin.answers.index',
                    ],
                ],
            ]),
            new NavigationElement([
                'name' => '??????????????',
                'route' => 'products',
                'icon' => 'i-versions',
                'compare' => ['products', 'categories'],
                'submenu' => [
                    'products' => [
                        'name' => '????????????',
                        'route' => 'admin.products.index',
                    ],
                    'categories' => [
                        'name' => '??????????????????',
                        'route' => 'admin.categories.index',
                    ]
                ],
            ]),
            new NavigationElement([
                'name' => '????????????',
                'route' => 'articles',
                'icon' => 'i-newspaper',
                'compare' => ['articles', 'tags', 'groups'],
                'submenu' => [
                    'articles' => [
                        'name' => '?????? ????????????',
                        'route' => 'admin.articles.index',
                    ],
                    'tags' => [
                        'name' => '????????',
                        'route' => 'admin.tags.index',
                    ],
                    'groups' => [
                        'name' => '???????????? ??????????',
                        'route' => 'admin.groups.index',
                    ],
                ],
            ]),
            new NavigationElement([
                'name' => '????????????',
                'route' => 'slides',
                'icon' => 'i-image',
                'submenu' => null,
            ]),
            new NavigationElement([
                'name' => '????????????????',
                'route' => 'pages',
                'icon' => 'i-book',
                'submenu' => null,
            ]),
        ];
        $admin =[];
        if(Auth::user()->hasRole('admin')){
            $admin = [
                new NavigationElement([
                    'name' => '??????????????????????',
                    'route' => 'accounting',
                    'icon' => 'i-versions',
                    'compare' => ['accounting', 'suppliers', 'statuses'],
                    'submenu' => [
                        'accounting' => [
                            'name' => '?????? ??????????????????????',
                            'route' => 'admin.accounting.index'
                        ],
                        'products' => [
                            'name' => '????????????????????',
                            'route' => 'admin.suppliers.index',
                        ],
                        'categories' => [
                            'name' => '??????????????',
                            'route' => 'admin.statuses.index',
                        ]
                    ],
                ]),
                new NavigationElement([
                    'name' => '????????????????????????',
                    'route' => 'users',
                    'icon' => 'i-users',
                    'submenu' => null,
                ]),
            ];
        }
        return array_merge($items, $admin);
    }
}
