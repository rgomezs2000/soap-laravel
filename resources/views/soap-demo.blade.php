{{-- resources/views/soap-demo.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SOAP Demo - Información de Países</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #667eea;
            margin-bottom: 10px;
            text-align: center;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 0.95em;
        }

        /* Pestañas */
        .tab-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
        }

        .tab-btn {
            width: auto;
            padding: 12px 20px;
            background: none;
            border: none;
            border-bottom: 3px solid transparent;
            color: #999;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .tab-btn.active {
            color: #667eea;
            border-bottom-color: #667eea;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Formularios */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #667eea;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .help-text {
            font-size: 0.85em;
            color: #999;
            margin-top: 5px;
        }

        .example-codes {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-top: 10px;
        }

        .code-btn {
            width: auto;
            padding: 8px 12px;
            background: #f0f4ff;
            border: 1px solid #667eea;
            color: #667eea;
            font-size: 0.9em;
        }

        .code-btn:hover {
            background: #667eea;
            color: white;
        }

        /* Resultados */
        .result {
            margin-top: 30px;
            padding: 20px;
            background: #f0f4ff;
            border-radius: 5px;
            border-left: 4px solid #667eea;
            display: none;
        }

        .result.show {
            display: block;
        }

        .result.error {
            background: #ffebee;
            border-left-color: #f44336;
        }

        .result h3 {
            color: #667eea;
            margin-bottom: 15px;
        }

        .result.error h3 {
            color: #c62828;
        }

        .result-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .result-row:last-child {
            border-bottom: none;
        }

        .result-label {
            color: #666;
            font-weight: 500;
        }

        .result-value {
            color: #333;
            font-weight: 600;
        }

        .loading {
            display: none;
            text-align: center;
            color: #667eea;
            margin-top: 20px;
        }

        .loading.show {
            display: block;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0%   { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Bandera grande */
        #flag-container{
            text-align: center;
            margin-bottom: 20px;
        }

        #flag-container img{
            max-width: 240px;
            width: 100%;
            border-radius: 6px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🌍 Demo SOAP - Información de Países</h1>
        <p class="subtitle">Consulta información de cualquier país usando Web Services SOAP</p>

        <div class="tab-buttons">
            <button type="button" class="tab-btn active" onclick="switchTab(0)">Por Código ISO</button>
            <button type="button" class="tab-btn" onclick="switchTab(1)">Por Nombre</button>
        </div>

        <!-- TAB 1: Por Código ISO -->
        <div class="tab-content active" id="tab0">
            <form id="form-by-code">
                <div class="form-group">
                    <label for="country-code">Código ISO del país (2 letras):</label>
                    <input
                        type="text"
                        id="country-code"
                        name="country_code"
                        placeholder="Ej: CL, US, ES, MX, AR"
                        maxlength="2"
                        required
                    >
                    <div class="help-text">Ejemplo: CL (Chile), US (USA), ES (España), MX (México), AR (Argentina)</div>

                    <div class="example-codes">
                        <button type="button" class="code-btn" onclick="setCode('CL')">Chile 🇨🇱</button>
                        <button type="button" class="code-btn" onclick="setCode('US')">USA 🇺🇸</button>
                        <button type="button" class="code-btn" onclick="setCode('ES')">España 🇪🇸</button>
                        <button type="button" class="code-btn" onclick="setCode('MX')">México 🇲🇽</button>
                        <button type="button" class="code-btn" onclick="setCode('AR')">Argentina 🇦🇷</button>
                    </div>
                </div>
                <button type="submit">Obtener Información</button>
            </form>
        </div>

        <!-- TAB 2: Por Nombre -->
        <div class="tab-content" id="tab1">
            <form id="form-by-name">
                <div class="form-group">
                    <label for="country-name">Nombre del país:</label>
                    <input
                        type="text"
                        id="country-name"
                        name="country_name"
                        placeholder="Ej: Chile, United States, Spain"
                        required
                    >
                    <div class="help-text">Escribe el nombre del país en inglés</div>
                </div>
                <button type="submit">Buscar País</button>
            </form>
        </div>

        <div class="loading" id="loading">
            <div class="spinner"></div>
            <p>Consultando servicio SOAP...</p>
        </div>

        <div class="result" id="result">
            <h3>Información del País</h3>
            <div id="flag-container"></div>
            <div id="result-content"></div>
        </div>
    </div>

    <script>
        // ---------- Utilidades ----------

        // Escapa texto para insertarlo de forma segura en el HTML
        function esc(text) {
            return String(text).replace(/[&<>"']/g, c => ({
                '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
            }[c]));
        }

        function csrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        // Envía un POST en JSON y devuelve la respuesta ya convertida
        async function postJson(url, body) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken()
                },
                body: JSON.stringify(body)
            });

            return response.json();
        }

        // ---------- Pestañas ----------

        function switchTab(index) {
            document.querySelectorAll('.tab-content').forEach((el, i) => {
                el.classList.toggle('active', i === index);
            });

            document.querySelectorAll('.tab-btn').forEach((el, i) => {
                el.classList.toggle('active', i === index);
            });

            document.getElementById('result').classList.remove('show', 'error');
        }

        function setCode(code) {
            document.getElementById('country-code').value = code;
        }

        // ---------- Formularios ----------

        document.getElementById('form-by-code').addEventListener('submit', async (e) => {
            e.preventDefault();

            const code = document.getElementById('country-code').value.trim().toUpperCase();

            if (code.length !== 2) {
                showError('El código ISO debe tener 2 letras');
                return;
            }

            await getCountryInfo(code);
        });

        document.getElementById('form-by-name').addEventListener('submit', async (e) => {
            e.preventDefault();

            const name = document.getElementById('country-name').value.trim();
            showLoading(true);

            try {
                const data = await postJson(
                    '{{ route("soap.search-country-iso-code") }}',
                    { country_name: name }
                );

                showLoading(false);

                if (data.success) {
                    await getCountryInfo(data.country_code);
                } else {
                    showError(data.error ?? data.message ?? 'País no encontrado');
                }
            } catch (error) {
                showError(error.message);
            }
        });

        // ---------- Consultas ----------

        async function getCountryInfo(code) {
            showLoading(true);

            try {
                const data = await postJson(
                    '{{ route("soap.get-full-country-info") }}',
                    { country_code: code }
                );

                showLoading(false);

                if (data.success) {
                    displayResults(data.data);
                } else {
                    showError(data.error ?? data.message ?? 'Error desconocido');
                }
            } catch (error) {
                showError(error.message);
            }
        }

        // ---------- Mostrar resultados ----------

        function displayResults(data) {
            const flag = data.flag_url && data.flag_url !== 'N/A'
                ? `<img src="${esc(data.flag_url)}" alt="Bandera" style="height:40px;">`
                : 'N/A';

            document.getElementById('result-content').innerHTML = `
                <div class="result-row">
                    <span class="result-label">País:</span>
                    <span class="result-value">${esc(data.name)}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">Capital:</span>
                    <span class="result-value">${esc(data.capital)}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">Continente (código):</span>
                    <span class="result-value">${esc(data.continent_code)}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">Moneda:</span>
                    <span class="result-value">${esc(data.currency_code)}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">Código telefónico:</span>
                    <span class="result-value">${esc(data.phone_code)}</span>
                </div>
                <div class="result-row">
                    <span class="result-label">Bandera:</span>
                    <span class="result-value">${flag}</span>
                </div>
            `;

            const result = document.getElementById('result');
            result.querySelector('h3').textContent = 'Información del País';
            result.classList.remove('error');
            result.classList.add('show');
            showFlag(data.flag_url, data.name);
        }

        function showError(message) {
            showLoading(false);

            const result = document.getElementById('result');
            document.getElementById('flag-container').innerHTML = '';
            result.querySelector('h3').textContent = '❌ Error';
            document.getElementById('result-content').innerHTML = `<p>${esc(message)}</p>`;
            result.classList.add('error', 'show');
        }

        function showLoading(show) {
            document.getElementById('loading').classList.toggle('show', show);
        }

        // ---------- Bandera ----------
        function showFlag(url, countryName){
            const container = document.getElementById('flag-container');

            if(!url || url === 'N/A')
            {
                container.innerHTML = '';
                return;
            }

            container.innerHTML = `
            <img src="${esc(url)}" alt="Bandera de ${esc(countryName)}">
            `;
        }
    </script>
</body>
</html>
