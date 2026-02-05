<?php
return [
    "resources" => [
        "permission" => [
            "label" => "Permission",
            "plural_label" => "Permissions",
            "title" => "Permissions",
            "form" => [
                "schema" => [
                    "name" => [
                        "label" => "Name"
                    ],
                    "guard_name" => [
                        "label" => "Guard Name"
                    ],
                ]
            ],
            "table" => [
                "columns" => [
                    "name" => [
                        "label" => "Name"
                    ],
                    "guard_name" => [
                        "label" => "Guard Name"
                    ],
                    "roles_count" => [
                        "label" => "Used By"
                    ]
                ]
            ]
        ],
        "role" => [
            "label" => "Role",
            "plural_label" => "Roles",
            "title" => "Roles",
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
                        "label" => "Guard Name"
                    ]
                ]
            ]
        ]
    ],
    "actions" => [
        "import_permissions" => [
            "label" => "Import Permissions",
            "modal" => [
                "heading" => "Import Permissions",
                "description" => "Import all permissions of the given role into the current role"
            ],
            "schema" => [
                "role_id" => [
                    "label" => "Role",
                ],
                "delete_existing" => [
                    "label" => "Delete existing permissions",
                    "helper_text" => "All existing permissions will be deleted before the new ones are added."
                ]
            ],
            "action" => [
                "notifications" => [
                    "role_missing" => [
                        "title" => "Role not found",
                        "description" => "The given role could not be found."
                    ],
                    "existing_permissions_deleted" => [
                        "title" => "Existing permissions deleted",
                        "description" => "All existing permissions have been deleted successfully."
                    ],
                    "permissions_imported" => [
                        "title" => "Permissions imported",
                        "description" => "All permissions have been imported successfully."
                    ]
                ]
            ]
        ]
    ],
];
