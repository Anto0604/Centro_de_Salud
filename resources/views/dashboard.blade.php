<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <!-- Tarjetas de estadísticas -->
        <div class="grid auto-rows-min gap-4 md:grid-cols-2 lg:grid-cols-4">
            <!-- Niños -->
            <div
                class="flex flex-col gap-2 rounded-xl border border-blue-700 bg-white p-4 dark:border-blue-700 dark:bg-neutral-800">
                <div class="text-sm font-medium text-black dark:text-neutral-400">
                    Niños
                </div>
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                    {{ $stats['ninos'] ?? 0 }}
                </div>
                <div class="text-xs text-black dark:text-neutral-500">
                    Menores de 18 años
                </div>
            </div>

            <!-- Niñas -->
            <div
                class="flex flex-col gap-2 rounded-xl border border-pink-700 bg-white p-4 dark:border-pink-700 dark:bg-neutral-800">
                <div class="text-sm font-medium text-black dark:text-neutral-400">
                    Niñas
                </div>
                <div class="text-2xl font-bold text-pink-600 dark:text-pink-400">
                    {{ $stats['ninas'] ?? 0 }}
                </div>
                <div class="text-xs text-black dark:text-neutral-500">
                    Menores de 18 años
                </div>
            </div>

            <!-- Hombres -->
            <div
                class="flex flex-col gap-2 rounded-xl border border-green-700 bg-white p-4 dark:border-green-700 dark:bg-neutral-800">
                <div class="text-sm font-medium text-black dark:text-neutral-400">
                    Hombres
                </div>
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                    {{ $stats['hombres'] ?? 0 }}
                </div>
                <div class="text-xs text-black dark:text-neutral-500">
                    18 años o más
                </div>
            </div>

            <!-- Mujeres -->
            <div
                class="flex flex-col gap-2 rounded-xl border border-purple-700 bg-white p-4 dark:border-purple-700 dark:bg-neutral-800">
                <div class="text-sm font-medium text-black dark:text-neutral-500">
                    Mujeres
                </div>
                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">
                    {{ $stats['mujeres'] ?? 0 }}
                </div>
                <div class="text-xs text-black dark:text-neutral-500">
                    18 años o más
                </div>
            </div>
        </div>

        <!-- Gráfico de distribución por género y edad -->
        <div class="grid gap-4 md:grid-cols-3">
            <div
                class="relative h-90 w-300 overflow-hidden rounded-xl border border-neutral-200 bg-white p-6 shadow-sm dark:border-white dark:bg-neutral-900">
                <canvas id="pacientesChart" class="w-full" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            let pacientesChart = null; 
            // Primera carga
            document.addEventListener('DOMContentLoaded', initPacientesChart);

            function initPacientesChart() {
                const chartContainer = document.getElementById('pacientesChart');
                if (!chartContainer) return;

            
                if (pacientesChart) {
                    pacientesChart.destroy();
                }

                const ctx = chartContainer.getContext('2d');

                const stats = @json($stats);

                pacientesChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Niños', 'Niñas', 'Hombres', 'Mujeres'],
                        datasets: [{
                            data: [
                                stats.ninos,
                                stats.ninas,
                                stats.hombres,
                                stats.mujeres
                            ],
                            backgroundColor: [
                                'rgba(59, 130, 246, 0.8)',
                                'rgba(236, 72, 153, 0.8)',
                                'rgba(34, 197, 94, 0.8)',
                                'rgba(139, 92, 246, 0.8)'
                            ],
                            borderColor: [
                                'rgb(59, 130, 246)',
                                'rgb(236, 72, 153)',
                                'rgb(34, 197, 94)',
                                'rgb(139, 92, 246)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                labels: {
                                    color: document.documentElement.classList.contains('dark')
                                        ? '#e5e7eb'
                                        : '#374151',
                                    font: {
                                        size: 14
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const percentage = ((context.parsed / total) * 100).toFixed(1);
                                        return `${context.label}: ${context.parsed} (${percentage}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            // Re-inicializar al navegar con Livewire
            document.addEventListener('livewire:navigated', () => {
                initPacientesChart();
            });

            // Re-inicializar al cambiar el tema
            document.documentElement.addEventListener('classChange', () => {
                initPacientesChart();
            });


        </script>
    @endpush
</x-layouts.app>