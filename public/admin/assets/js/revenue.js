document.addEventListener("DOMContentLoaded", function() {
            let apexChartInstance = null; // Biến để giữ instance của biểu đồ ApexCharts
            let currentFilterParams = {}; // Lưu trữ tham số lọc hiện tại cho auto-refresh

            const headerStatElements = {
                orders: document.getElementById('header-orders'),
                earnings: document.getElementById('header-earnings'),
                canceled: document.getElementById('header-canceled'),
                conversion: document.getElementById('header-conversion')
            };

            // Hàm animate giá trị số
            function animateValue(obj, start, end, duration) {
                if (!obj) return;
                const initialText = obj.textContent;
                const currentStart = parseFloat(initialText.replace(/[^\d.-]/g, '')) || 0;
                if (isNaN(currentStart) || currentStart === end) {
                    if (typeof end === 'number') {
                        obj.textContent = obj.id === 'header-earnings' ? `$${end.toLocaleString()}` :
                            obj.id === 'header-conversion' ? `${end.toFixed(1)}%` :
                            end.toLocaleString();
                    }
                    return;
                }
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const currentValue = progress * (end - currentStart) + currentStart;
                    if (obj.id === 'header-earnings') {
                        obj.textContent = `$${Math.floor(currentValue).toLocaleString()}`;
                    } else if (obj.id === 'header-conversion') {
                        obj.textContent = `${currentValue.toFixed(1)}%`;
                    } else {
                        obj.textContent = Math.floor(currentValue).toLocaleString();
                    }
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    } else {
                        if (obj.id === 'header-earnings') {
                            obj.textContent = `$${end.toLocaleString()}`;
                        } else if (obj.id === 'header-conversion') {
                            obj.textContent = `${end.toFixed(1)}%`;
                        } else if (typeof end === 'number') {
                            obj.textContent = end.toLocaleString();
                        }
                    }
                };
                window.requestAnimationFrame(step);
            }

            // Hàm cập nhật các số liệu thống kê ở header
            function updateHeaderStats(data) {
                if (!data) return;
                if (headerStatElements.orders && data.totalOrders !== undefined) {
                    animateValue(headerStatElements.orders,
                        parseFloat(headerStatElements.orders.textContent.replace(/[^\d.-]/g, '')) || 0,
                        data.totalOrders, 1000);
                }
                if (headerStatElements.earnings && data.totalEarnings !== undefined) {
                    animateValue(headerStatElements.earnings,
                        parseFloat(headerStatElements.earnings.textContent.replace(/[^\d.-]/g, '')) || 0,
                        data.totalEarnings, 1000);
                }
                if (headerStatElements.canceled && data.totalCanceled !== undefined) {
                    animateValue(headerStatElements.canceled,
                        parseFloat(headerStatElements.canceled.textContent.replace(/[^\d.-]/g, '')) || 0,
                        data.totalCanceled, 1000);
                }
                if (headerStatElements.conversion && data.conversionRate !== undefined) {
                    animateValue(headerStatElements.conversion,
                        parseFloat(headerStatElements.conversion.textContent.replace(/[^\d.-]/g, '')) || 0,
                        data.conversionRate, 1000);
                }
                // if (headerStatElements.totalCustomers && data.totalCustomers !== undefined) {
                //     animateValue(headerStatElements.totalCustomers,
                //         parseFloat(headerStatElements.totalCustomers.textContent.replace(/[^\d.-]/g, '')) || 0,
                //         data.totalCustomers, 1000);
                // }

                document.querySelectorAll('[data-target]').forEach(el => {
                    const key = el.getAttribute('data-target');
                    if (data[key] !== undefined) {
                        const start = parseFloat(el.textContent.replace(/[^\d.-]/g, '')) || 0;
                        const end = parseFloat(data[key]);
                        animateValue(el, start, end, 1000);
                    }
                });
            }

            // Hàm cập nhật dữ liệu biểu đồ
            function updateChartDisplay(data) {
                if (!apexChartInstance || !data) return;
                const series = [{
                    name: 'Orders',
                    data: data.orders || []
                }, {
                    name: 'Earnings',
                    data: data.earnings || []
                }, {
                    name: 'Cancelled',
                    data: data.cancelled || []
                }];
                apexChartInstance.updateSeries(series);
                if (data.categories) {
                    apexChartInstance.updateOptions({
                        xaxis: {
                            categories: data.categories
                        }
                    });
                }
            }

            // Hàm fetch dữ liệu từ API với các tham số lọc
            async function fetchAndProcessRevenueData(params = {}) {
                try {
                    const queryParams = new URLSearchParams();
                    if (params.startDate && params.endDate) {
                        queryParams.append('startDate', params.startDate);
                        queryParams.append('endDate', params.endDate);
                    } else if (params.filter) {
                        queryParams.append('filter', params.filter);
                    }
                    const response = await fetch(`/api/getRevenueData?${queryParams.toString()}`);
                    const data = await response.json();
                    if (data.error) {
                        throw new Error(data.message);
                    }
                    updateChartDisplay(data);
                    updateHeaderStats(data);
                    currentFilterParams = params; // Cập nhật tham số lọc hiện tại
                } catch (error) {
                    console.error("Error fetching or processing data:", error);
                    alert("Có lỗi xảy ra khi tải dữ liệu: " + error.message);
                }
            }

            // Hàm khởi tạo biểu đồ ban đầu
            function initializeChart() {
                var options = {
                    series: [{
                        name: 'Orders',
                        type: 'column',
                        data: []
                    }, {
                        name: 'Earnings',
                        type: 'area',
                        data: []
                    }, {
                        name: 'Cancelled',
                        type: 'line',
                        data: []
                    }],
                    chart: {
                        height: 350,
                        type: 'line',
                        stacked: false,
                        toolbar: {
                            show: true
                        }
                    },
                    stroke: {
                        width: [0, 2, 3],
                        curve: 'smooth'
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '30%',
                            borderRadius: 4
                        }
                    },
                    fill: {
                        opacity: [1, 0.25, 1],
                        gradient: {
                            inverseColors: false,
                            shade: 'light',
                            type: "vertical",
                            opacityFrom: 0.85,
                            opacityTo: 0.55,
                            stops: [0, 100, 100, 100]
                        }
                    },
                    markers: {
                        size: 0
                    },
                    xaxis: {
                        categories: [],
                        labels: {
                            style: {
                                colors: '#777'
                            }
                        }
                    },
                    yaxis: [
                        {
                            title: {
                                text: "Orders & Cancelled",
                                style: {
                                    color: '#777'
                                }
                            },
                            labels: {
                                formatter: function (val) {
                                    return val.toFixed(0);
                                }
                            }
                        },
                        {
                            opposite: true,
                            title: {
                                text: "Earnings ($)",
                                style: {
                                    color: '#777'
                                }
                            },
                            labels: {
                                formatter: function (val) {
                                    return "$" + val.toFixed(0) + "k";
                                }
                            }
                        }
                    ],
                    tooltip: {
                        shared: true,
                        intersect: false,
                        y: [{
                            formatter: function (y) {
                                return y !== undefined ? y.toLocaleString() + " orders" : y;
                            }
                        }, {
                            formatter: function (y) {
                                return y !== undefined ? "$" + y.toLocaleString() + "k" : y;
                            }
                        }, {
                            formatter: function (y) {
                                return y !== undefined ? y.toLocaleString() + " cancelled" : y;
                            }
                        }]
                    },
                    legend: {
                        position: 'top',
                        horizontalAlign: 'right',
                        offsetY: -25,
                        offsetX: -5
                    },
                    colors: ['#405189', '#0ab39c', '#f06548']
                };

                const chartElement = document.querySelector("#customer_impression_charts");
                if (chartElement) {
                    apexChartInstance = new ApexCharts(chartElement, options);
                    apexChartInstance.render();
                }
            }

            // Hàm cài đặt các bộ lọc
            function setupFilters() {
                const startDateInput = document.getElementById('startDate');
                const endDateInput = document.getElementById('endDate');
                const filterDateButton = document.getElementById('filterDate');
                const quickFilterButtons = document.querySelectorAll('.btn-group button[data-filter]');

                // Đặt ngày mặc định (30 ngày trước đến hôm nay)
                const today = new Date();
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(today.getDate() - 30);
                if (startDateInput) startDateInput.valueAsDate = thirtyDaysAgo;
                if (endDateInput) endDateInput.valueAsDate = today;

                // Params cho lần load đầu tiên
                currentFilterParams = {
                    startDate: thirtyDaysAgo.toISOString().split('T')[0],
                    endDate: today.toISOString().split('T')[0]
                };

                // Sự kiện cho nút Filter Date
                if (filterDateButton) {
                    filterDateButton.addEventListener('click', function() {
                        const startDateValue = startDateInput ? startDateInput.value : null;
                        const endDateValue = endDateInput ? endDateInput.value : null;
                        if (startDateValue && endDateValue) {
                            const params = {
                                startDate: startDateValue,
                                endDate: endDateValue
                            };
                            fetchAndProcessRevenueData(params);
                            currentFilterParams = params;
                        } else {
                            alert("Vui lòng chọn cả ngày bắt đầu và ngày kết thúc.");
                        }
                    });
                }

                // Sự kiện cho các nút Quick Filter
                quickFilterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        quickFilterButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');
                        const filterType = this.dataset.filter;
                        const todayDate = new Date();
                        let startFilterDate = new Date();
                        let params = {};
                        switch (filterType) {
                            case 'month':
                                startFilterDate.setMonth(todayDate.getMonth() - 1);
                                params = {
                                    startDate: startFilterDate.toISOString().split('T')[0],
                                    endDate: todayDate.toISOString().split('T')[0]
                                };
                                break;
                            case 'halfYear':
                                startFilterDate.setMonth(todayDate.getMonth() - 6);
                                params = {
                                    startDate: startFilterDate.toISOString().split('T')[0],
                                    endDate: todayDate.toISOString().split('T')[0]
                                };
                                break;
                            case 'year':
                                startFilterDate.setFullYear(todayDate.getFullYear() - 1);
                                params = {
                                    startDate: startFilterDate.toISOString().split('T')[0],
                                    endDate: todayDate.toISOString().split('T')[0]
                                };
                                break;
                            case 'all':
                            default:
                                params = { filter: 'all' };
                                if (startDateInput) startDateInput.value = '';
                                if (endDateInput) endDateInput.value = '';
                                break;
                        }
                        if (filterType !== 'all') {
                            if (startDateInput) startDateInput.valueAsDate = startFilterDate;
                            if (endDateInput) endDateInput.valueAsDate = todayDate;
                        }
                        fetchAndProcessRevenueData(params);
                        currentFilterParams = params;
                    });
                });
            }

            // --- KHỞI CHẠY ---
            initializeChart(); // Khởi tạo biểu đồ rỗng trước
            setupFilters();    // Cài đặt các bộ lọc và sự kiện

            // Load dữ liệu lần đầu
            const initialActiveButton = document.querySelector('.btn-group button[data-filter="all"].active');
            if (initialActiveButton) {
                fetchAndProcessRevenueData({ filter: 'all' });
                currentFilterParams = { filter: 'all' };
            } else if (currentFilterParams.startDate && currentFilterParams.endDate) {
                fetchAndProcessRevenueData(currentFilterParams);
            }

            // Tự động cập nhật mỗi 5 phút
            setInterval(() => {
                console.log("Auto-refreshing chart with params:", currentFilterParams);
                fetchAndProcessRevenueData(currentFilterParams);
            }, 5 * 60 * 1000);
        });