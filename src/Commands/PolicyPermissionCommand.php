<?php

namespace SLNE\FilamentAuthorization\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Gate;
use SLNE\FilamentAuthorization\Policies\FilamentPolicy;
use Spatie\Permission\Models\Permission;

class PolicyPermissionCommand extends Command
{
    private function findPolicy(string $name): ?FilamentPolicy
    {
        $policyClasses = Gate::policies();

        foreach ($policyClasses as $model => $policyClass) {
            if ($policyClass == $name) {
                return new $policyClass();
            }
        }

        return null;
    }

    public static function createPermissions(FilamentPolicy $policy, string $guard = 'web'): void
    {
        $permissions = $policy->getAllPermissions();

        foreach ($permissions as $permission) {
            self::createPermission($permission, $guard);
        }
    }

    public static function createPermission(string $permission, string $guard = 'web'): void
    {
        if (!Permission::where('name', $permission)->exists()) {
            Permission::create([
                'name' => $permission,
                'guard_name' => $guard,
            ]);
        }
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:policy {policy} {--guard=web}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates all permission needed by the given policy';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->argument('policy');
        $guard = $this->option('guard');

        if (empty($name)) {
            $this->error('Permission name is required.');
            return 1;
        }

        if (empty($guard)) {
            $guard = 'web';
        }

        $policy = self::findPolicy($name);

        if ($policy == null) {
            $this->error("Policy for '$name' could not be found.");
            return 1;
        }

        self::createPermissions($policy, $guard);

        $this->info("All permissions for '$name' have been processed.");

        return 0;
    }
}
