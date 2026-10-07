<?php

namespace App\Http;

class SwaggerSpec
{
    public static function get(): array
    {
        return [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Alumni Tracking & Community Networking System API',
                'version' => '1.0.0',
                'description' => 'Haftalık olarak geliştirilen Alumni web uygulamasının MVC mimarisinde (UserController & ApiUserController) çalışan tüm RESTful API ve Web rotalarını içeren interaktif Swagger dokümantasyonu.',
                'contact' => [
                    'name' => 'Dilara MUMCU',
                    'email' => 'dilaramumcu.ogr.iu.edu.tr'
                ]
            ],
            'servers' => [
                [
                    'url' => 'http://localhost:8000',
                    'description' => 'Yerel Geliştirme Sunucusu (Docker / Localhost)'
                ]
            ],
            'tags' => [
                [
                    'name' => 'API Users (ApiUserController)',
                    'description' => 'RESTful JSON API uç noktaları (App\Http\Controllers\ApiUserController tarafından yönetilir)'
                ],
                [
                    'name' => 'Web Users (UserController)',
                    'description' => 'Web arayüzü ve form uç noktaları (App\Http\Controllers\UserController tarafından yönetilir)'
                ],
                [
                    'name' => 'API Announcements (ApiAnnouncementController)',
                    'description' => 'Duyuru RESTful JSON API uç noktaları (App\Http\Controllers\ApiAnnouncementController tarafından yönetilir)'
                ],
                [
                    'name' => 'Web Announcements (AnnouncementController)',
                    'description' => 'Duyuru Web arayüzü ve yönetim uç noktaları (App\Http\Controllers\AnnouncementController tarafından yönetilir)'
                ],
                [
                    'name' => 'System & Health',
                    'description' => 'Sistem durumu ve sağlık kontrolleri'
                ],
                [
                    'name' => 'Documentation',
                    'description' => 'Swagger UI ve OpenAPI JSON dokümantasyon rotaları'
                ],
                [
                    'name' => 'Web Pages & Basic Routes',
                    'description' => 'Temel web rotaları, şablonlar ve yardımcı sayfalar'
                ]
            ],
            'paths' => [
                /* ------------------------------------------------------------------ */
                /*             API Users (ApiUserController - JSON Responses)         */
                /* ------------------------------------------------------------------ */
                '/api/users' => [
                    'get' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Tüm kullanıcıları listele (JSON)',
                        'description' => 'ApiUserController@index tarafından işlenir. Kayıtlı tüm mezun ve öğrenci listesini döner.',
                        'responses' => [
                            '200' => [
                                'description' => 'Başarılı kullanıcılar listesi',
                                'content' => [
                                    'application/json' => [
                                        'example' => [
                                            'success' => true,
                                            'count' => 3,
                                            'data' => [
                                                [
                                                    'id' => 1,
                                                    'name' => 'Dilara MUMCU',
                                                    'email' => 'dilaramumcu.ogr.iu.edu.tr',
                                                    'role' => 'student',
                                                    'department' => 'MIS',
                                                    'graduation_year' => 2028,
                                                    'current_company' => 'Samsung',
                                                    'job_title' => 'Data Scientist',
                                                    'linkedin_url' => null,
                                                    'skills' => null,
                                                    'created_at' => '2024-06-15T10:00:00Z',
                                                    'updated_at' => '2026-09-30T12:23:15+00:00'
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'post' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Yeni kullanıcı oluştur (JSON)',
                        'description' => 'ApiUserController@store tarafından işlenir. User Model üzerinden veritabanı olmadan Cache üzerinde yeni kullanıcı kaydeder.',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'required' => ['name', 'email'],
                                        'properties' => [
                                            'name' => ['type' => 'string', 'example' => 'Dilara MUMCU'],
                                            'email' => ['type' => 'string', 'example' => 'dilaramumcu.ogr.iu.edu.tr'],
                                            'role' => ['type' => 'string', 'example' => 'student'],
                                            'department' => ['type' => 'string', 'example' => 'MIS'],
                                            'graduation_year' => ['type' => 'integer', 'example' => 2028],
                                            'current_company' => ['type' => 'string', 'example' => 'Samsung'],
                                            'job_title' => ['type' => 'string', 'example' => 'Data Scientist'],
                                            'linkedin_url' => ['type' => 'string', 'example' => 'https://linkedin.com/in/dilaramumcu'],
                                            'skills' => [
                                                'type' => 'array',
                                                'items' => ['type' => 'string'],
                                                'example' => ['PHP', 'Laravel', 'Docker', 'MySQL']
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '201' => [
                                'description' => 'Kullanıcı başarıyla oluşturuldu',
                                'content' => [
                                    'application/json' => [
                                        'example' => [
                                            'success' => true,
                                            'message' => 'User created successfully and stored without database (via Cache)!',
                                            'data' => [
                                                'id' => 4,
                                                'name' => 'Dilara MUMCU',
                                                'email' => 'dilaramumcu.ogr.iu.edu.tr',
                                                'role' => 'student'
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                '/api/users/{id}' => [
                    'get' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Tekil kullanıcıyı getir (JSON)',
                        'description' => 'ApiUserController@show tarafından işlenir. Belirtilen ID\'ye sahip kullanıcının detaylarını döner.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı bulundu'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ],
                    'put' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Kullanıcıyı tam değiştir (Full Replacement)',
                        'description' => 'ApiUserController@update tarafından işlenir. REST standardına göre gönderilmeyen/boş alanlar null yapılır.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'example' => [
                                        'name' => 'Dilara MUMCU',
                                        'email' => 'dilaramumcu.ogr.iu.edu.tr',
                                        'role' => 'student',
                                        'department' => 'MIS',
                                        'graduation_year' => 2028,
                                        'current_company' => 'Samsung',
                                        'job_title' => 'Data Scientist',
                                        'linkedin_url' => null,
                                        'skills' => null
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı başarıyla tam güncellendi (eksik alanlar null yapıldı)'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ],
                    'patch' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Kullanıcıyı kısmi güncelle (Partial Update)',
                        'description' => 'ApiUserController@update tarafından işlenir. Yalnızca gönderilen alanlar güncellenir, diğerleri korunur.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'example' => [
                                        'current_company' => 'Google DeepMind',
                                        'job_title' => 'Senior AI Engineer'
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kısmi güncelleme başarılı'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ],
                    'delete' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Kullanıcıyı sil (JSON)',
                        'description' => 'ApiUserController@destroy tarafından işlenir. Belirtilen ID\'ye sahip kullanıcıyı sistemden siler.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 3
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı başarıyla silindi'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ]
                ],
                '/api/users/reset' => [
                    'post' => [
                        'tags' => ['API Users (ApiUserController)'],
                        'summary' => 'Kullanıcı listesini başlangıç verilerine sıfırla',
                        'description' => 'ApiUserController@reset tarafından işlenir. Test ve geliştirme için kullanıcı listesini fabrika ayarlarına döndürür.',
                        'responses' => [
                            '200' => [
                                'description' => 'Kullanıcılar başarıyla sıfırlandı',
                                'content' => [
                                    'application/json' => [
                                        'example' => [
                                            'success' => true,
                                            'message' => 'Users list reset to initial defaults.',
                                            'data' => []
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                /* ------------------------------------------------------------------ */
                /*             Web Users (UserController - Web Views & Forms)         */
                /* ------------------------------------------------------------------ */
                '/users' => [
                    'get' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Web kullanıcı rehberini listele',
                        'description' => 'UserController@index tarafından işlenir. Kullanıcı listesini web/view olarak döner.',
                        'responses' => [
                            '200' => ['description' => 'Başarılı web görünümü / kullanıcı listesi']
                        ]
                    ],
                    'post' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Web formu üzerinden kullanıcı kaydet',
                        'description' => 'UserController@store tarafından işlenir. Form verilerini alır ve kullanıcıyı kaydeder.',
                        'responses' => [
                            '201' => ['description' => 'Kullanıcı başarıyla oluşturuldu'],
                            '302' => ['description' => 'Web yönlendirmesi']
                        ]
                    ]
                ],
                '/users/create' => [
                    'get' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Yeni kullanıcı oluşturma formunu aç',
                        'description' => 'UserController@create tarafından işlenir. Kullanıcı ekleme form arayüzünü döner.',
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı form şablonu']
                        ]
                    ]
                ],
                '/users/{id}' => [
                    'get' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Web kullanıcı profilini göster',
                        'description' => 'UserController@show tarafından işlenir. Kullanıcı detay sayfasını sunar.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı profili sayfası'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ],
                    'put' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Web kullanıcı profilini güncelle',
                        'description' => 'UserController@update tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı güncellendi'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ],
                    'delete' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Web üzerinden kullanıcıyı sil',
                        'description' => 'UserController@destroy tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Kullanıcı silindi'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ]
                ],
                '/users/{id}/edit' => [
                    'get' => [
                        'tags' => ['Web Users (UserController)'],
                        'summary' => 'Kullanıcı düzenleme formunu aç',
                        'description' => 'UserController@edit tarafından işlenir. Kullanıcı düzenleme arayüzünü döner.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Düzenleme form şablonu'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ]
                ],

                /* ------------------------------------------------------------------ */
                /*     API Announcements (ApiAnnouncementController - JSON CRUD)      */
                /* ------------------------------------------------------------------ */
                '/api/announcements' => [
                    'get' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Tüm duyuruları listele (JSON)',
                        'description' => 'ApiAnnouncementController@index tarafından işlenir. Aktif ve öncelikli tüm duyuruları döner.',
                        'responses' => [
                            '200' => ['description' => 'Başarılı duyuru listesi']
                        ]
                    ],
                    'post' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Yeni duyuru oluştur (JSON)',
                        'description' => 'ApiAnnouncementController@store tarafından işlenir. Yeni duyuruyu önbelleğe kaydeder.',
                        'requestBody' => [
                            'required' => true,
                            'content' => [
                                'application/json' => [
                                    'example' => [
                                        'title' => '2026 Mezunlar Zirvesi',
                                        'content' => 'Mezunlar Zirvesi kayıtları başlamıştır.',
                                        'category' => 'event',
                                        'author' => 'Mezunlar Koordinatörlüğü',
                                        'target_audience' => 'all',
                                        'priority' => 'important',
                                        'pinned' => true
                                    ]
                                ]
                            ]
                        ],
                        'responses' => [
                            '201' => ['description' => 'Duyuru başarıyla oluşturuldu']
                        ]
                    ]
                ],
                '/api/announcements/{id}' => [
                    'get' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Tekil duyuru detayı (JSON)',
                        'description' => 'ApiAnnouncementController@show tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Duyuru bulundu'],
                            '404' => ['description' => 'Duyuru bulunamadı']
                        ]
                    ],
                    'put' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Duyuruyu tam güncelle (PUT)',
                        'description' => 'ApiAnnouncementController@update tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Duyuru güncellendi'],
                            '404' => ['description' => 'Duyuru bulunamadı']
                        ]
                    ],
                    'delete' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Duyuruyu sil (DELETE)',
                        'description' => 'ApiAnnouncementController@destroy tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Duyuru silindi'],
                            '404' => ['description' => 'Duyuru bulunamadı']
                        ]
                    ]
                ],
                '/api/announcements/reset' => [
                    'post' => [
                        'tags' => ['API Announcements (ApiAnnouncementController)'],
                        'summary' => 'Duyuruları başlangıç verilerine sıfırla',
                        'description' => 'ApiAnnouncementController@reset tarafından işlenir.',
                        'responses' => [
                            '200' => ['description' => 'Duyurular sıfırlandı']
                        ]
                    ]
                ],

                /* ------------------------------------------------------------------ */
                /*     Web Announcements (AnnouncementController - Web Views & Forms) */
                /* ------------------------------------------------------------------ */
                '/announcements' => [
                    'get' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Duyuru yönetim arayüzünü listele',
                        'description' => 'AnnouncementController@index tarafından işlenir. Duyuru paneli Blade şablonunu döner.',
                        'responses' => [
                            '200' => ['description' => 'Başarılı web görünümü']
                        ]
                    ],
                    'post' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Web formu ile yeni duyuru yayınla',
                        'description' => 'AnnouncementController@store tarafından işlenir.',
                        'responses' => [
                            '302' => ['description' => 'Yönlendirme (Duyurular listesine)']
                        ]
                    ]
                ],
                '/announcements/create' => [
                    'get' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Yeni duyuru formu arayüzü',
                        'description' => 'AnnouncementController@create tarafından işlenir.',
                        'responses' => [
                            '200' => ['description' => 'Duyuru oluşturma formu']
                        ]
                    ]
                ],
                '/announcements/{id}' => [
                    'get' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Web duyuru detay sayfası',
                        'description' => 'AnnouncementController@show tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Duyuru detay sayfası'],
                            '404' => ['description' => 'Duyuru bulunamadı']
                        ]
                    ],
                    'put' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Web üzerinden duyuru güncelle',
                        'description' => 'AnnouncementController@update tarafından işlenir.',
                        'responses' => [
                            '302' => ['description' => 'Yönlendirme']
                        ]
                    ],
                    'delete' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Web üzerinden duyuru sil',
                        'description' => 'AnnouncementController@destroy tarafından işlenir.',
                        'responses' => [
                            '302' => ['description' => 'Yönlendirme']
                        ]
                    ]
                ],
                '/announcements/{id}/edit' => [
                    'get' => [
                        'tags' => ['Web Announcements (AnnouncementController)'],
                        'summary' => 'Duyuru düzenleme formu',
                        'description' => 'AnnouncementController@edit tarafından işlenir.',
                        'parameters' => [
                            [
                                'name' => 'id',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 1
                            ]
                        ],
                        'responses' => [
                            '200' => ['description' => 'Duyuru düzenleme formu'],
                            '404' => ['description' => 'Duyuru bulunamadı']
                        ]
                    ]
                ],

                /* ------------------------------------------------------------------ */
                /*                      System, Health & Documentation                */
                /* ------------------------------------------------------------------ */
                '/api/health' => [
                    'get' => [
                        'tags' => ['System & Health'],
                        'summary' => 'Sistem sağlık kontrolü (JSON)',
                        'description' => 'Uygulamanın aktif ve çalışır olduğunu doğrulayan JSON sağlık yanıtı döner.',
                        'responses' => [
                            '200' => [
                                'description' => 'Sistem çalışıyor',
                                'content' => [
                                    'application/json' => [
                                        'example' => ['status' => 'ok']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                '/api/swagger' => [
                    'get' => [
                        'tags' => ['Documentation'],
                        'summary' => 'Swagger Dokümantasyonu (JSON / HTML)',
                        'description' => 'Tarayıcıdan açıldığında interaktif Swagger UI web arayüzünü, Postman veya API istemcilerinden çağrıldığında OpenAPI 3.0 JSON spesifikasyonunu döner.',
                        'parameters' => [
                            [
                                'name' => 'format',
                                'in' => 'query',
                                'required' => false,
                                'description' => "Çıktı formatını zorlamak için 'json' veya 'html' girilebilir.",
                                'schema' => [
                                    'type' => 'string',
                                    'enum' => ['json', 'html']
                                ]
                            ]
                        ],
                        'responses' => [
                            '200' => [
                                'description' => 'Başarılı Dokümantasyon Yanıtı (JSON veya HTML)',
                                'content' => [
                                    'application/json' => [
                                        'schema' => ['type' => 'object']
                                    ],
                                    'text/html' => [
                                        'schema' => ['type' => 'string']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],
                '/api/swagger.json' => [
                    'get' => [
                        'tags' => ['Documentation'],
                        'summary' => 'Swagger OpenAPI JSON Spesifikasyonu',
                        'description' => 'Postman Import veya harici araçlar için doğrudan saf OpenAPI 3.0 JSON çıktısı döner.',
                        'responses' => [
                            '200' => [
                                'description' => 'OpenAPI 3.0 JSON Spesifikasyonu',
                                'content' => [
                                    'application/json' => [
                                        'schema' => ['type' => 'object']
                                    ]
                                ]
                            ]
                        ]
                    ]
                ],

                /* ------------------------------------------------------------------ */
                /*                      Web Pages & Basic Routes                      */
                /* ------------------------------------------------------------------ */
                '/' => [
                    'get' => [
                        'tags' => ['Web Pages & Basic Routes'],
                        'summary' => 'Geçici Ana Sayfa (Blade View)',
                        'responses' => ['200' => ['description' => 'HTML Sayfası']]
                    ]
                ],
                '/about' => [
                    'get' => [
                        'tags' => ['Web Pages & Basic Routes'],
                        'summary' => 'Geçici Hakkında Sayfası (Blade View)',
                        'responses' => ['200' => ['description' => 'HTML Sayfası']]
                    ]
                ],
                '/hello' => [
                    'get' => [
                        'tags' => ['Web Pages & Basic Routes'],
                        'summary' => 'Sabit Merhaba Mesajı',
                        'responses' => ['200' => ['description' => "'Hello, world!'"]]
                    ]
                ],
                '/hello/{name}' => [
                    'get' => [
                        'tags' => ['Web Pages & Basic Routes'],
                        'summary' => 'Dinamik İsimli Merhaba',
                        'parameters' => [
                            [
                                'name' => 'name',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'string'],
                                'example' => 'dilara'
                            ]
                        ],
                        'responses' => ['200' => ['description' => "'Hello, Dilara!'"]]
                    ]
                ],
                '/sum/{number1}/{number2}' => [
                    'get' => [
                        'tags' => ['Web Pages & Basic Routes'],
                        'summary' => 'İki Sayının Toplamı',
                        'parameters' => [
                            [
                                'name' => 'number1',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 5
                            ],
                            [
                                'name' => 'number2',
                                'in' => 'path',
                                'required' => true,
                                'schema' => ['type' => 'integer'],
                                'example' => 3
                            ]
                        ],
                        'responses' => ['200' => ['description' => "'8'"]]
                    ]
                ]
            ]
        ];
    }
}
