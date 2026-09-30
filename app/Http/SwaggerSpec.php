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
                'description' => 'Haftalık olarak geliştirilen Alumni web uygulamasının tüm RESTful ve Web rotalarını içeren interaktif Swagger dokümantasyonu.',
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
                ['name' => 'Users', 'description' => 'Mezun ve öğrenci profili CRUD işlemleri (In-Memory / File Cache)'],
                ['name' => 'System & Health', 'description' => 'Sistem durumu ve sağlık kontrolleri'],
                ['name' => 'Documentation', 'description' => 'API ve Swagger dokümantasyon rotaları'],
                ['name' => 'Web Pages & Basic Routes', 'description' => 'Temel web rotaları ve sayfalar']
            ],
            'paths' => [
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
                '/api/health' => [
                    'get' => [
                        'tags' => ['System & Health'],
                        'summary' => 'Sistem sağlık kontrolü',
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
                '/api/users' => [
                    'get' => [
                        'tags' => ['Users'],
                        'summary' => 'Tüm kullanıcıları listele',
                        'description' => 'Kayıtlı tüm mezun ve öğrencilerin listesini döner.',
                        'responses' => [
                            '200' => [
                                'description' => 'Kullanıcılar listesi',
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
                        'tags' => ['Users'],
                        'summary' => 'Yeni kullanıcı oluştur',
                        'description' => 'Yeni bir mezun veya öğrenci profili ekler (In-Memory / File Cache).',
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
                                            'message' => 'User created successfully',
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
                        'tags' => ['Users'],
                        'summary' => 'Tekil kullanıcıyı getir',
                        'description' => "Belirtilen ID'ye sahip kullanıcının detaylarını döner.",
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
                        'tags' => ['Users'],
                        'summary' => 'Kullanıcıyı tam değiştir (Full Replacement)',
                        'description' => 'REST standartlarına uygun olarak kullanıcının tüm bilgilerini değiştirir. İstekte gönderilmeyen veya boş bırakılan alanlar null yapılır.',
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
                        'tags' => ['Users'],
                        'summary' => 'Kullanıcıyı kısmi güncelle (Partial Update)',
                        'description' => 'Yalnızca istekte gönderilen alanları günceller, diğer mevcut alanları aynen korur.',
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
                                        'job_title' => 'AI Engineer'
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
                        'tags' => ['Users'],
                        'summary' => 'Kullanıcıyı sil',
                        'description' => "Belirtilen ID'ye sahip kullanıcıyı sistemden siler.",
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
                            '200' => ['description' => 'Kullanıcı silindi'],
                            '404' => ['description' => 'Kullanıcı bulunamadı']
                        ]
                    ]
                ],
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
