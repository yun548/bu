<?php

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use function Laravel\Folio\{middleware, name};
use App\Forms\StoreDetailsForm;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Volt\Component;
use App\Models\Activity;
use App\Models\Store;
use App\Managers\StoreManager;
use App\Data\StoreData;

middleware('auth');
name('onboarding.step-2');

new class extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema(
            StoreDetailsForm::schema()
        )->statePath('data');
    }

    public function save()
    {
        $state = $this->form->getState();
        $this->validate();
        $storeData = new StoreData($state);
        StoreManager::createStore($storeData, auth()->user());
        Notification::make()
            ->title('Magasin enregistré !')
            ->success()
            ->send();
    }
}

?>

<x-layouts.app>
    <x-app.container x-data class="lg:space-y-6" x-cloak>
        <x-app.heading
            title="Étape 2 : Informations du magasin"
            description="Bienvenue dans la seconde étape de votre parcours d'intégration. Veuillez remplir les informations de votre magasin pour continuer."
            :border="true"
        />
        @volt('onboarding.step_2')
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
