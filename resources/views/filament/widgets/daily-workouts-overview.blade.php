{{-- @vite('resources/css/app.css') --}}
<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-lg font-bold mb-2">Today's Schedule</h2>
        <div class=" flex flex-wrap md:grid md:grid-cols-2 space-y-4 md:space-y-0 md:gap-2 xl:grid xl:grid-cols-3 ">


            @if (empty($workouts))
                <p>No workouts scheduled for today.</p>
            @else
                @foreach ($workouts as $workout)
                    <div class="w-full flex flex-row border border-gray-400 rounded-lg overflow-hidden shadow-lg ">
                        <!-- Image Section -->
                        <div class="h-36 lg:h-32 flex-none bg-contain bg-center mx-auto sm:mx-0"
                            style="height: 9rem; width: 9rem; background-repeat: no-repeat; background-image: url('{{ $workout['library']['image'] ? Storage::url($workout['library']['image']) : asset('storage/images/wplanner_noimg.png') }}');"
                            title="Workout Image">
                        </div>

                        <!-- Content Section -->
                        <div class="w-full lg:w-2/3   sm:p-2 flex flex-col justify-between">
                            <!-- Top Section -->
                            <div class="mt-2 ">
                                <p class="text-sm text-gray-600">{{ $workout['library']['sources']['name'] ?? 'N/A' }}
                                </p>
                                <div class="text-gray-300 font-bold text-lg md:text-sm mb-2">
                                    {{ $workout['library']['name'] }}</div>
                                <p class="text-gray-300 text-base">
                                    {{ \Carbon\Carbon::parse($workout['time'])->format('h:i A') }}
                                </p>
                            </div>

                            <!-- Bottom Section -->
                            <div class="flex sm:space-x-2 text-sm lg:text-xs text-gray-600 flex-wrap mb-2 ">
                                <p class="mr-2 sm:mr-0">{{ $workout['library']['main_types']['name'] ?? 'N/A' }}</p>
                                <p>{{ $workout['library']['second_types']['name'] ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
