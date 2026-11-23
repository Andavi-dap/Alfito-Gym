<?php

namespace Tests\Feature;

use App\Models\MembershipPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GymWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_membership_plans_index(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.plans.index'))
            ->assertOk();
    }

    public function test_member_can_apply_for_membership_and_make_payment(): void
    {
        $member = User::factory()->create(['role' => 'member']);
        $admin = User::factory()->create(['role' => 'admin']);
        $plan = MembershipPlan::factory()->create();

        $this->actingAs($member)
            ->post(route('member.applications.store'), [
                'membership_plan_id' => $plan->id,
            ])
            ->assertRedirect();

        $application = $member->applications()->latest()->first();

        // Admin reviews and approves to move to awaiting_payment state
        $this->actingAs($admin)
            ->patch(route('admin.applications.review', $application), [
                'decision' => 'approve',
            ])
            ->assertRedirect();

        $this->actingAs($member)
            ->post(route('member.applications.payment.store', $application), [
                'proof' => UploadedFile::fake()->create('proof.pdf', 10, 'application/pdf'),
                'reference_number' => 'REF-001',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('payments', [
            'membership_application_id' => $application->id,
            'amount' => $plan->price,
            'status' => 'pending',
        ]);
    }
}
