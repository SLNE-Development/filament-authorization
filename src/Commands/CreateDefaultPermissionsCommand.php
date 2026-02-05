<?php

namespace SLNE\FilamentAuthorization\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use JetBrains\PhpStorm\NoReturn;
use SLNE\FilamentAuthorization\Http\Policies\FilamentPolicy;
use Spatie\Permission\Models\Permission;

class CreateDefaultPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:create-default';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates the default permissions using the registered policies.';

    private function collectPolicies(): Collection
    {
        return collect(Gate::policies())
            ->map(fn(string $policyClassName) => new $policyClassName())
            ->filter(fn($policy) => $policy instanceof FilamentPolicy);
    }

    /**
     * Execute the console command.
     */
    #[NoReturn]
    public function handle(): void
    {
        $tableNames = config('permission.table_names');
        $permissionTableName = $tableNames['permissions'];

        $policies = $this->collectPolicies();
        $policyPermissions = $policies->map(fn(FilamentPolicy $policy) => $policy->getAllPermissions())
            ->flatten()
            ->unique();

        $deleteExisting = $this->confirm('Do you want to delete existing permissions before creating default ones?');

        if ($deleteExisting) {
            Permission::query()->delete();
            DB::statement("ALTER TABLE $permissionTableName AUTO_INCREMENT = 1;");
            $this->info("Existing permissions deleted and auto increment reset.");
        }

        $policyPermissions->prepend("*");

        $policyPermissionsWithGuard = $policyPermissions->map(fn(string $permission) => [
            "name" => $permission,
            "guard_name" => 'web',
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        Permission::insert($policyPermissionsWithGuard->toArray());

        $this->info("Default permissions created.");
    }
}
