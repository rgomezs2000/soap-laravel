{{-- resources/views/soap-demo.blade.php --}}
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SOAP Demo - Información de Países</title>
        <style>
            *{
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body{
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #667eea0 0%, #764ba2 100%);
                min-height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
            }

            .container{
                background: white;
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
                max-width: 600px;
                width: 100%;
            }

            h1{
                color: #667eea;
                margin-bottom: 10px;
                text-align: center;
            }

            .subtitle{
                text-align: center;
                color: #666;
                margin-bottom: 30px;
                font-size: 0.95em;
            }

            .tab-buttons{
                display: flex;
                gap: 10px;
                margin-bottom: 30px;
                border-bottom: 2px solid #eee;
            }

            .tab-btn{
                padding: 12px 20px;
                background: none;
                border: none;
                cursor: pointer;
                color: #999;
                font-weight: 500;
                border-bottom: 3px solid transparent;
                transition: all 0.3s;
            }

            .tab-btn.active{
                color: #667eea;
                border-bottom-color: #667eea;
            }

            .tab-container{
                display: none;
            }

            .tab-content.active{
                display: block;
            }

            .form-group{
                margin-bottom: 20px;
            }

            label{
                display: block;
                margin-bottom: 8px;
                color: #333;
                font-weight: 500;
            }

            input, select{
                width: 100%;
                padding: 12px;
                border: 2px solid #ddd;
                border-radius: 5px;
                font-size: 16px;
                transition: border-color 0.3s;
                font-family: inherit;
            }

            input:focus, select:focus{
                outline: none;
                border-color: #667eea;
            }

            button{
                width: 100%;
                padding: 12px;
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
                border: none;
                border-radius: 5px;
                font-weight: 600;
                cursor: pointer;
                transition: transform 0.2s;
            }
            button:hover{
                transform: translateY(-2px);
            }

            button:active{
                transform: translateX(0);
            }

            .result{
                margin-top: 30px;
                padding: 20px;
                background: #f0f4ff;
                border-radius: 5px;
                border-left: 4px solid #667eea;
                display: none;
            }

            .result.show{
                display: block;
            }

            .result h3{
                color: #667eea;
                margin-bottom: 15px;
            }

            .result-row{
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid #ddd;
            }

            .result-row:last-child{
                border-bottom: none;
            }

            .result-label:{
                color: #666;
                font-weight: 500;
            }

            .result-value{
                color: #333;
                font-weight: 600;
            }

            .error{
                background: #ffebee !important;
                border-left-color: #f44336 !important;
            }

            .error h3{
                color: #c62828 !important;
            }

            .loading{
                display: none;
                text-align: center;
                color: #667eea;
                margin-top: 20px;
            }

            .loading.show{
                display: block;
            }

            .spinner{
                border: 4px solid #f3f3f3;
                border-top: 4px solid #667eea;
                border-radius: 50%;
                width: 40px;
                height: 40px;
                animation: spin 1s linear infinite;
                margin: 0 auto 15px;
            }

            @keyframes spin{
                0%{
                    transform: rotate(0deg);
                }

                100%{
                    transform: rotate(360deg);
                }
            }

            .help-text{
                font-size: 0.85em;
                color: #999;
                margin-top: 5px;
            }

            .example-code{
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 8px;
                margin-top: 10px;
            }

            .code-btn{
                padding: 8px, 12px;
                background: #f0f4ff;
                border: 1px solid #667eea;
                color: #667eea;
                font-size: 0.9em;
                transition: all 0.3s;
            }

            .code-btn:hover{
                background: #667eea;
                color: white;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>🌍 Demo SOAP - Información de Países</h1>
            <p class="subtitle">Consulta información de cualquier país usando Web Services SOAP</p>
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchTab(0)"Por Codigo ISO></button>
                <button class="tab-btn active" onclick="switchTab(1)"Por Nombre></button>
            </div>
            <!-- TAB 1: Por Código ISO -->
            <div class="tab-content active" id="tab0">
                <form id="form-by-code">
                    <div></div>
                </form>
            </div>
        </div>
    </body>
</html>
