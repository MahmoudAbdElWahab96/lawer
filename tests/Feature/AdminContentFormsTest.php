<?php

namespace Tests\Feature;

use App\Filament\Resources\ContactMessageResource\Pages\ListContactMessages;
use App\Filament\Resources\PracticeAreaResource\Pages\EditPracticeArea;
use App\Models\ContactMessage;
use App\Models\PracticeArea;
use App\Models\User;
use Database\Seeders\PracticeAreaSeeder;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminContentFormsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_practice_area_keeps_its_landing_icon_when_saved(): void
    {
        $this->seed(PracticeAreaSeeder::class);
        $practiceArea = PracticeArea::query()->where('icon', 'fd282.svg')->firstOrFail();

        Livewire::test(EditPracticeArea::class, ['record' => $practiceArea->getRouteKey()])
            ->assertSchemaStateSet(['icon' => 'fd282.svg'])
            ->call('save')
            ->assertHasNoErrors();

        $this->assertSame('fd282.svg', $practiceArea->refresh()->icon);
    }

    public function test_opening_a_message_marks_it_read(): void
    {
        $message = ContactMessage::query()->create([
            'name' => 'موكل تجريبي',
            'phone' => '01012345678',
            'message' => 'أحتاج استشارة',
            'locale' => 'ar',
            'is_read' => false,
        ]);

        Livewire::test(ListContactMessages::class)
            ->mountAction(TestAction::make('view')->table($message))
            ->assertActionMounted(TestAction::make('view')->table($message));

        $this->assertTrue($message->refresh()->is_read);
    }
}
