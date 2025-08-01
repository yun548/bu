<?php

use App\Forms\UserDetailsForm;
use function Laravel\Folio\{middleware, name};
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Volt\Component;
use App\Managers\UserManager;
use App\Data\UserData;

middleware('auth');
name('onboarding.step-1');

new class extends Component implements HasForms {
    use InteractsWithForms;
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form->schema(
            UserDetailsForm::schema(auth()->user())
        )->statePath('data');
    }
    
    public function save()
    {
        $state = $this->form->getState();
        $this->validate();
        $userData = new UserData($state);
        UserManager::updateUser(auth()->user(), $userData);
        Notification::make()->title('Successfully saved your profile settings')->success()->send();
        return redirect('/onboarding/step-2');
    }
}
?>

<x-layouts.app>
    <x-app.container x-data class="lg:space-y-6" x-cloak>
        <x-app.heading
            title="Étape 1 : Informations du profil"
            description="Bienvenue dans la première étape de votre parcours d'intégration. Veuillez remplir les informations de votre profil pour continuer."
            :border="true"
        />
        @volt('onboarding.step_1')
        <div class="relative w-full">
            <form wire:submit="save" class="w-full">
                <div class="relative flex flex-col mt-5 lg:px-10">
                    <div class="w-full mt-8">
                        {{ $this->form }}
                    </div>
                    <div class="w-full pt-6 text-right">
                        <x-button type="submit">Enregistrer</x-button>
                    </div>
                </div>

            </form>
        </div>
        @endvolt
    </x-app.container>
</x-layouts.app>
