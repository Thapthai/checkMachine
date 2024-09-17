@push('script')
    <!-- โหลด Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <!-- Script สำหรับวาดกราฟวงกลม -->
    <script>
        window.onload = function() {
            var ctx = document.getElementById('appPieChart').getContext('2d');
            var appPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ตรวจสอบ', 'ไม่ใช้งาน', 'ไม่ได้ตรวจสอบ'],
                    datasets: [{
                        label: 'แผนการตรวจสอบ',
                        data: [
                            {{ count($schedulePlansRecord) }},
                            {{ count($schedulePlansRecordNotUse) }},
                            {{ count($schedulePlans) - $checkingRecordCount }}
                        ],
                        backgroundColor: [
                            '#FED9ED',
                            '#F5CCA0',
                            '#C23373'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'สถานะการตรวจสอบแผนการ'
                        }
                    }
                }
            });

            var ctx = document.getElementById('cleanPieChart2').getContext('2d');
            var cleanPieChart2 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ผ่าน', 'ไม่ผ่าน'],
                    datasets: [{
                        label: 'แผนการตรวจสอบ',
                        data: [
                            {{ count($schedulePlansRecordResult_clean_pass) }},
                            {{ count($schedulePlansRecordResult_clean_not) }},

                        ],
                        backgroundColor: [
                            '#9DBDFF',
                            '#FFD7C4',

                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'สถานะการตรวจความสมบูรณ์'
                        }
                    }
                }
            });

            var ctx = document.getElementById('completePieChart3').getContext('2d');
            var completePieChart3 = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['ผ่าน', 'ไม่ผ่าน'],
                    datasets: [{
                        label: 'แผนการตรวจสอบ',
                        data: [
                            {{ count($schedulePlansRecordResult_complete_pass) }},
                            {{ count($schedulePlansRecordResult_complete_not) }},

                        ],
                        backgroundColor: [
                            '#AAD9BB',
                            '#FFCF96',

                        ]
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'สถานะการตรวจความสมบูรณ์'
                        }
                    }
                }
            });

        };
    </script>
@endpush
