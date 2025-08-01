<?php
    use Filament\Forms\Components\TextInput;
    use function Laravel\Folio\{middleware, name};
    use Filament\Forms\Concerns\InteractsWithForms;
    use Filament\Forms\Contracts\HasForms;
    use Filament\Forms\Form;
    use Filament\Notifications\Notification;
	use Livewire\Volt\Component;

	middleware('auth');
    name('settings.profile');

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
            return $form
                ->schema([
                     TextInput::make('last_name')
                         ->label('Nom')
                         ->required()
                         ->rules('required|string')
                         ->default(auth()->user()->last_name),
                    TextInput::make('first_name')
                        ->label('Prénom')
                        ->required()
						->rules('required|string')
						->default(auth()->user()->first_name),
                    TextInput::make('phone')
                        ->label('Numéro de téléphone')
                        ->required()
                        ->rules([
                            'required',
                            'regex:/^0[1-9]\d{8}$/',
                            'unique:users,phone,' . auth()->user()->id,
                        ])
                        ->default(auth()->user()->phone)
                        ->maxLength(10),
					TextInput::make('email')
                        ->label('Adresse e-mail')
                        ->required()
						->rules('sometimes|required|email|unique:users,email,' . auth()->user()->id)
						->default(auth()->user()->email),
                ])
                ->statePath('data');
        }

		public function save()
		{
			$state = $this->form->getState();

            $this->validate();
			$this->saveFormFields($state);


			Notification::make()
                ->title('Successfully saved your profile settings')
                ->success()
                ->send();
		}

		private function saveFormFields($state){

			auth()->user()->first_name = $state['first_name'];
			auth()->user()->last_name = $state['last_name'];
            auth()->user()->email = $state['email'];
            auth()->user()->phone = $state['phone'];
			auth()->user()->save();
		}

	}
?>

<x-layouts.app>

    <x-app.settings-layout
        title="Paramètres"
        description="Modifiez votre nom, email, et numéro de téléphone.">
		@volt('settings.profile')
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
    </x-app.settings-layout>
</x-layouts.app>
