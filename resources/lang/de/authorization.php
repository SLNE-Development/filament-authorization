<?php
return [
    "resources" => [
        "permission" => [
            "label" => "Berechtigung",
            "plural_label" => "Berechtigungen",
            "title" => "Berechtigungen",
            "form" => [
                "schema" => [
                    "name" => [
                        "label" => "Name"
                    ],
                    "guard_name" => [
                        "label" => "Guard-Name"
                    ],
                ]
            ],
            "table" => [
                "columns" => [
                    "name" => [
                        "label" => "Name"
                    ],
                    "guard_name" => [
                        "label" => "Guard-Name"
                    ],
                    "roles_count" => [
                        "label" => "Verwendet von"
                    ]
                ]
            ]
        ],
        "role" => [
            "label" => "Rolle",
            "plural_label" => "Rollen",
            "title" => "Rollen",
            "form" => [
                "schema" => [
                    "name" => [
                        "label" => "Name"
                    ],
                ]
            ],
            "table" => [
                "columns" => [
                    "name" => [
                        "label" => "Name"
                    ],
                    "guard_name" => [
                        "label" => "Guard-Name"
                    ]
                ]
            ]
        ]
    ],
    "actions" => [
        "import_permissions" => [
            "label" => "Berechtigungen importieren",
            "modal" => [
                "heading" => "Berechtigungen importieren",
                "description" => "Importiere alle Berechtigungen der angegebenen Rolle in die aktuelle Rolle"
            ],
            "schema" => [
                "role_id" => [
                    "label" => "Rolle",
                ],
                "delete_existing" => [
                    "label" => "Bestehende Berechtigungen löschen",
                    "helper_text" => "Alle bestehenden Berechtigungen werden gelöscht, bevor die neuen hinzugefügt werden."
                ]
            ],
            "action" => [
                "notifications" => [
                    "role_missing" => [
                        "title" => "Rolle nicht gefunden",
                        "description" => "Die angegebene Rolle konnte nicht gefunden werden."
                    ],
                    "existing_permissions_deleted" => [
                        "title" => "Bestehende Berechtigungen gelöscht",
                        "description" => "Alle bestehenden Berechtigungen wurden erfolgreich gelöscht."
                    ],
                    "permissions_imported" => [
                        "title" => "Berechtigungen importiert",
                        "description" => "Alle Berechtigungen wurden erfolgreich importiert."
                    ]
                ]
            ]
        ]
    ]
];
