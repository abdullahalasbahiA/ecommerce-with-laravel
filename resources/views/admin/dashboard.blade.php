<!-- resources/views/admin/dashboard.blade.php -->
<x-my-layout>
    <div class="p-6 space-y-6">

        <h1 class="text-2xl font-bold">Dashboard</h1>

        <!-- Example Dashboard Stats Section -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white shadow p-4 rounded-xl">
        <h2 class="text-sm text-gray-500">Total Payments</h2>
        <p class="text-xl font-bold">{{ $totalPayments }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded-xl">
        <h2 class="text-sm text-gray-500">Completed</h2>
        <p class="text-xl font-bold text-green-600">{{ $completedPayments }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded-xl">
        <h2 class="text-sm text-gray-500">Pending</h2>
        <p class="text-xl font-bold text-yellow-600">{{ $pendingPayments }}</p>
    </div>
    <div class="bg-white shadow p-4 rounded-xl">
        <h2 class="text-sm text-gray-500">Total Revenue</h2>
        <p class="text-xl font-bold text-blue-600">${{ number_format($totalRevenue) }}</p>
    </div>
</div>

<!-- Pie Chart Section -->
<div class="bg-white p-6 shadow rounded-xl mt-6">
    <h2 class="text-lg font-semibold mb-4">Payment Status Distribution</h2>
    <canvas id="statusPieChart" width="400" height="200"></canvas>
</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('statusPieChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($paymentStatuses) !!},
            datasets: [{
                data: {!! json_encode($paymentCounts) !!},
                backgroundColor: [
                    'rgb(34, 197, 94)',   // Green
                    'rgb(250, 204, 21)',  // Yellow
                    'rgb(239, 68, 68)'    // Red
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'right',
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.label || '';
                            let value = context.parsed || 0;
                            return `${label}: ${value} payments`;
                        }
                    }
                }
            }
        }
    });
</script>



    
</x-my-layout>
