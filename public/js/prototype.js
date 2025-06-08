// Menunggu seluruh halaman HTML dimuat sebelum menjalankan script
document.addEventListener('DOMContentLoaded', function () {
    const apiUrl = 'http://127.0.0.1:8000/api';
    let authToken = localStorage.getItem('fitnest_token');

    // Referensi ke elemen-elemen HTML
    const loginSection = document.getElementById('login-section');
    const dashboardSection = document.getElementById('dashboard-section');
    const loginForm = document.getElementById('login-form');
    const logoutButton = document.getElementById('logout-button');
    const addFoodForm = document.getElementById('add-food-form');
    const chatbotForm = document.getElementById('chatbot-form');

    // --- FUNGSI-FUNGSI UTAMA ---

    // Fungsi untuk memanggil API dengan header otentikasi
    async function fetchAPI(endpoint, options = {}) {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...options.headers,
        };
        if (authToken) {
            headers['Authorization'] = `Bearer ${authToken}`;
        }

        const response = await fetch(apiUrl + endpoint, { ...options, headers });

        if (!response.ok) {
            if (response.status === 401) {
                // Jika token tidak valid, otomatis logout
                logout();
            }
            const errorData = await response.json();
            throw new Error(errorData.message || 'Terjadi kesalahan pada server.');
        }
        return response.json();
    }

    // Fungsi untuk memuat semua data dashboard
    async function loadDashboard() {
        try {
            const [user, summaryResponse] = await Promise.all([
                fetchAPI('/user'),
                fetchAPI('/dashboard/summary')
            ]);

            document.getElementById('user-name').textContent = user.name;
            const summary = summaryResponse.summary;
            document.getElementById('calories-consumed').textContent = `${summary.calories_consumed} kcal`;
            document.getElementById('calories-burned').textContent = `${summary.calories_burned} kcal`;
            document.getElementById('net-calories').textContent = `${summary.net_calories} kcal`;
            document.getElementById('calorie-goal').textContent = `${summary.calorie_goal} kcal`;
            
            loginSection.style.display = 'none';
            dashboardSection.style.display = 'block';

        } catch (error) {
            console.error('Gagal memuat dashboard:', error);
        }
    }

    // Fungsi untuk logout
    function logout() {
        localStorage.removeItem('fitnest_token');
        authToken = null;
        dashboardSection.style.display = 'none';
        loginSection.style.display = 'flex';
    }


    // --- EVENT LISTENERS ---

    // Event listener untuk form login
    loginForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const errorDiv = document.getElementById('login-error');
        errorDiv.textContent = '';

        try {
            const response = await fetch(apiUrl + '/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ email, password }),
            });

            // --- PENANDA DEBUGGING ---
            console.log('Response object mentah dari /login:', response);
            const data = await response.json();
            console.log('Data JSON dari /login:', data);
            // --- AKHIR PENANDA DEBUGGING ---

            if (!response.ok) throw new Error(data.message || 'Respons tidak OK');
            
            authToken = data.access_token; 
            localStorage.setItem('fitnest_token', authToken);

            console.log('Token yang disimpan:', authToken);

            await loadDashboard();

        } catch (error) {
            errorDiv.textContent = error.message || 'Email atau password salah.';
            console.error("Terjadi error saat proses login:", error);
        }
    });

    // Event listener untuk tombol logout
    logoutButton.addEventListener('click', logout);

    // Event listener untuk menambah catatan makanan
    addFoodForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const foodName = document.getElementById('food-name').value;
        const calories = document.getElementById('food-calories').value;

        if (!foodName || !calories) return alert('Nama makanan dan kalori harus diisi.');

        try {
            await fetchAPI('/food-logs', {
                method: 'POST',
                body: JSON.stringify({
                    food_name: foodName,
                    calories: parseInt(calories),
                    protein: 0, fat: 0, carbs: 0,
                    meal_type: 'snack',
                    log_date: new Date().toISOString().slice(0, 10)
                })
            });
            alert('Catatan makanan berhasil disimpan!');
            addFoodForm.reset();
            await loadDashboard();
        } catch (error) {
            alert('Gagal menyimpan: ' + error.message);
        }
    });

    // Event listener untuk chatbot
    chatbotForm.addEventListener('submit', async function (e) {
        e.preventDefault();
        const questionInput = document.getElementById('chatbot-question');
        const replyDiv = document.getElementById('chatbot-reply');
        
        if (!questionInput.value) return;
        replyDiv.textContent = 'FitBot sedang mengetik...';
        
        try {
            const response = await fetchAPI('/chatbot', {
                method: 'POST',
                body: JSON.stringify({ question: questionInput.value })
            });
            replyDiv.textContent = response.reply;
            questionInput.value = '';
        } catch (error) {
            replyDiv.textContent = 'Maaf, terjadi kesalahan: ' + error.message;
        }
    });


    // --- LOGIKA AWAL ---
    if (authToken) {
        loadDashboard();
    }
});