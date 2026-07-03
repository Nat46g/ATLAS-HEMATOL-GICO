<?php
// Este é um arquivo PHP que contém todo o HTML, CSS e JavaScript do Atlas Hematológico
// Nenhuma lógica PHP adicional é necessária, pois o site é totalmente front-end
// O arquivo pode ser renomeado para index.php e funcionará normalmente
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Atlas Hematológico - Quiz com feedback</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9edf2 100%);
            color: #2c3e50;
            line-height: 1.6;
        }
        .main-header {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f, #fdbb4d);
            background-size: 200% 200%;
            animation: gradientShift 10s ease infinite;
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .main-header h1 { font-size: 2rem; letter-spacing: 2px; margin-bottom: 0.5rem; }
        .main-header p { opacity: 0.9; }
        .nav-tabs {
            display: flex;
            justify-content: center;
            background: white;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border-radius: 50px;
            margin: -25px 20px 20px 20px;
            padding: 0.5rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }
        .tab-btn {
            background: transparent;
            border: none;
            padding: 0.8rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 40px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #2c3e50;
        }
        .tab-btn.active {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .tab-btn:hover:not(.active) { background: #ecf0f1; transform: translateY(-2px); }
        .container { max-width: 1400px; margin: 0 auto; padding: 20px; }
        .tab-content { display: none; animation: fadeIn 0.4s ease; }
        .tab-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 20px 30px rgba(0,0,0,0.15); }
        .card-img { width: 100%; height: 180px; object-fit: cover; cursor: pointer; }
        .card-badge {
            position: absolute;
            background: #b21f1f;
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            margin: 10px;
            top: 0;
            left: 0;
        }
        .card-content { padding: 1.2rem; position: relative; }
        .card-categoria {
            display: inline-block;
            background: #e9edf2;
            padding: 0.2rem 0.8rem;
            border-radius: 15px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #1a2a6c;
            margin-bottom: 0.5rem;
        }
        .card-titulo { font-size: 1.2rem; font-weight: 700; color: #1a2a6c; margin-bottom: 0.5rem; }
        .card-texto { font-size: 0.85rem; color: #555; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .card-btn {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            margin-top: 1rem;
            cursor: pointer;
            font-size: 0.8rem;
            transition: 0.2s;
        }
        .card-btn:hover { transform: scale(1.02); }
        
        .card-referencia {
            border: 2px solid #fdbb4d;
            background: #fef9e6;
        }
        .card-referencia .card-badge {
            background: #fdbb4d;
            color: #1a2a6c;
        }
        .card-referencia .card-categoria {
            background: #fdbb4d;
            color: #1a2a6c;
        }
        .card-referencia .card-titulo {
            color: #b21f1f;
        }
        .card-referencia .card-btn {
            background: linear-gradient(135deg, #fdbb4d, #b21f1f);
        }
        .card-referencia .card-texto {
            -webkit-line-clamp: 10;
            font-size: 0.8rem;
        }
        .card-referencia .card-texto li {
            margin-bottom: 0.3rem;
        }
        .card-referencia .card-texto ul {
            padding-left: 1.2rem;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.9);
            z-index: 1000;
            justify-content: center;
            align-items: center;
        }
        .modal.active { display: flex; }
        .modal-content {
            position: relative;
            width: 90%;
            max-width: 1000px;
            max-height: 90vh;
            background: white;
            border-radius: 20px;
            overflow-y: auto;
        }
        .modal-header {
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .modal-body { padding: 1.5rem; }
        .modal-img { width: 100%; max-height: 300px; object-fit: cover; border-radius: 12px; margin-bottom: 1rem; }
        .close-modal {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: white;
            z-index: 20;
        }
        .video-btn-modal {
            background: #b21f1f;
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            margin-top: 1rem;
            cursor: pointer;
            transition: 0.2s;
        }
        .video-btn-modal:hover { transform: scale(1.02); }
        
        .quiz-container { max-width: 900px; margin: 0 auto; }
        .quiz-header {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 1rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            margin-bottom: 2rem;
        }
        .quiz-score {
            display: flex;
            gap: 2rem;
            font-weight: 600;
        }
        .quiz-score span { background: #f1f3f5; padding: 0.3rem 1rem; border-radius: 40px; }
        .quiz-score .acertos { color: #2e7d32; }
        .quiz-score .erros { color: #c62828; }
        .quiz-nivel {
            display: inline-block;
            padding: 0.3rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
        .nivel-Fácil { background: #4caf50; color: white; }
        .nivel-Médio { background: #ff9800; color: white; }
        .nivel-Difícil { background: #f44336; color: white; }
        .quiz-card {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.2s;
        }
        .quiz-pergunta { font-size: 1.1rem; font-weight: 600; margin-bottom: 1rem; }
        .quiz-opcao {
            background: #f1f3f5;
            margin: 0.5rem 0;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.2s;
        }
        .quiz-opcao:hover { background: #e2e6ea; }
        .quiz-opcao.selected { background: #d4e0ff; border-left: 4px solid #1a2a6c; }
        .quiz-opcao.correta { background: #c8e6c9; border-left: 4px solid #2e7d32; }
        .quiz-opcao.incorreta { background: #ffcdd2; border-left: 4px solid #c62828; }
        .quiz-feedback-inline {
            margin-top: 1rem;
            padding: 0.8rem 1rem;
            border-radius: 12px;
            font-weight: 500;
            display: none;
        }
        .quiz-feedback-inline.correta {
            display: block;
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
            color: #1e4620;
        }
        .quiz-feedback-inline.incorreta {
            display: block;
            background: #ffebee;
            border-left: 4px solid #f44336;
            color: #b71c1c;
        }
        .quiz-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            margin-top: 1rem;
        }
        .quiz-submit-btn {
            background: #1a2a6c;
            color: white;
            border: none;
            padding: 0.6rem 1.8rem;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }
        .quiz-submit-btn:hover { background: #b21f1f; transform: scale(1.02); }
        .quiz-submit-btn:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }
        .quiz-reset-btn {
            background: #6c757d;
            color: white;
            border: none;
            padding: 0.6rem 1.8rem;
            border-radius: 40px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }
        .quiz-reset-btn:hover { background: #495057; }
        
        .search-panel {
            background: white;
            border-radius: 20px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .search-box {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .search-box input {
            flex: 1;
            padding: 0.8rem 1.2rem;
            border: 2px solid #e9edf2;
            border-radius: 40px;
            font-size: 1rem;
            min-width: 200px;
        }
        .search-box input:focus { border-color: #1a2a6c; outline: none; }
        .search-box select, .search-box button {
            padding: 0.8rem 1.5rem;
            border-radius: 40px;
            border: none;
            background: #1a2a6c;
            color: white;
            cursor: pointer;
            transition: 0.2s;
        }
        .search-box select:hover, .search-box button:hover { background: #b21f1f; }
        
        .resultado-item {
            background: #f8f9fc;
            border-radius: 15px;
            padding: 1rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: 0.2s;
            border-left: 4px solid #1a2a6c;
        }
        .resultado-item:hover { background: #e9edf2; transform: translateX(5px); }
        .destaque { background: #fdbb4d; color: #1a2a6c; font-weight: bold; padding: 0 4px; border-radius: 4px; }
        .resultado-termos { font-size: 0.8rem; color: #666; margin-top: 0.3rem; }
        .resultado-termos span { background: #e9edf2; padding: 2px 8px; border-radius: 12px; margin-right: 4px; font-size: 0.7rem; }
        .guia-estudos {
            background: #fef9e6;
            border-radius: 20px;
            padding: 1.5rem;
        }
        .guia-estudos ul { margin: 0.5rem 0 0.5rem 1.5rem; }
        footer { text-align: center; padding: 2rem; background: #1a2a6c; color: white; margin-top: 3rem; }

        .sobre-container {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 1000px;
            margin: 0 auto;
        }
        .sobre-container h2 {
            color: #1a2a6c;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            border-bottom: 3px solid #fdbb4d;
            padding-bottom: 0.5rem;
            display: inline-block;
        }
        .sobre-container h3 {
            color: #b21f1f;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .sobre-container p {
            color: #444;
            line-height: 1.8;
            margin-bottom: 1rem;
        }
        .sobre-container .autora-box {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            align-items: center;
            background: #f8f9fc;
            border-radius: 16px;
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-left: 5px solid #fdbb4d;
        }
        .sobre-container .autora-box .foto {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            background: #e9edf2;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
        }
        .sobre-container .autora-box .info {
            flex: 1;
        }
        .sobre-container .autora-box .info h4 {
            font-size: 1.3rem;
            color: #1a2a6c;
        }
        .sobre-container .autora-box .info .badge-autora {
            background: #fdbb4d;
            color: #1a2a6c;
            padding: 0.2rem 0.8rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            display: inline-block;
            margin-top: 0.3rem;
        }
        .btn-atlas-original {
            display: inline-block;
            background: linear-gradient(135deg, #1a2a6c, #b21f1f);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            margin-top: 1rem;
            transition: 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-atlas-original:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(178, 31, 31, 0.3);
        }
        .sobre-container .citacao {
            font-style: italic;
            background: #fef9e6;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            border-left: 4px solid #fdbb4d;
            margin: 1rem 0;
        }
        .sobre-container .citacao::before {
            content: '"';
            font-size: 2rem;
            color: #b21f1f;
            margin-right: 0.3rem;
        }
        .sobre-container .citacao::after {
            content: '"';
            font-size: 2rem;
            color: #b21f1f;
            margin-left: 0.3rem;
        }
        
        .video-modal-content {
            background: #000;
            max-width: 900px;
            padding: 0;
            border-radius: 16px;
            overflow: hidden;
        }
        .video-modal-content .video-wrapper {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
        }
        .video-modal-content .video-wrapper iframe,
        .video-modal-content .video-wrapper video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        .video-modal-content .close-video {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: white;
            z-index: 20;
            background: rgba(0,0,0,0.5);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .video-modal-content .close-video:hover { background: rgba(0,0,0,0.8); }
        
        @media (max-width: 768px) {
            .cards-grid { grid-template-columns: 1fr; }
            .nav-tabs { margin-top: -15px; }
            .tab-btn { padding: 0.4rem 1rem; font-size: 0.8rem; }
            .search-box input { min-width: 100%; }
            .quiz-header { flex-direction: column; gap: 0.5rem; }
            .quiz-score { gap: 1rem; }
            .sobre-container { padding: 1.5rem; }
            .sobre-container .autora-box { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>

<header class="main-header">
    <h1>🧬 ATLAS HEMATOLÓGICO</h1>
    <p>Auxílio de estudo do Curso Técnico de Análises Clínicas / Biomedicina</p>
</header>

<div class="nav-tabs">
    <button class="tab-btn active" data-tab="atlas">📖 Atlas Digital</button>
    <button class="tab-btn" data-tab="quiz">🧠 Quiz Interativo</button>
    <button class="tab-btn" data-tab="estudos">🔍 Central de Estudos</button>
    <button class="tab-btn" data-tab="sobre">👩‍🔬 Sobre o Atlas</button>
</div>

<div class="container">
    <div id="atlas" class="tab-content active">
        <div class="cards-grid" id="cardsGrid"></div>
    </div>

    <div id="quiz" class="tab-content">
        <div class="quiz-container">
            <div class="quiz-header">
                <h2 style="color:#1a2a6c; margin:0;">🧪 Teste seus conhecimentos</h2>
                <div class="quiz-score">
                    <span class="acertos">✅ Acertos: <span id="acertosCont">0</span></span>
                    <span class="erros">❌ Erros: <span id="errosCont">0</span></span>
                    <span>📊 <span id="totalRespondidas">0</span>/30</span>
                </div>
                <button class="quiz-reset-btn" onclick="reiniciarQuiz()">🔄 Reiniciar Quiz</button>
            </div>
            <p style="color:#555; margin-bottom:1rem;">Clique na opção e depois em "Responder". O feedback aparece ao lado do botão.</p>
            <hr style="margin: 1rem 0;" />
            <div id="quizContainer"></div>
        </div>
    </div>

    <div id="estudos" class="tab-content">
        <div class="search-panel">
            <h3>🔎 Pesquisa Inteligente no Atlas</h3>
            <p style="color:#666; margin-bottom:1rem;">Digite palavras-chave, características ou sinônimos. Ex: "célula anucleada", "núcleo em ferradura", "transporte de oxigênio"</p>
            <div class="search-box">
                <input type="text" id="termoBusca" placeholder="Digite um termo, característica ou função..." />
                <select id="categoriaFiltro">
                    <option value="">Todas as categorias</option>
                </select>
                <button onclick="realizarBusca()">🔍 Pesquisar</button>
                <button onclick="limparBusca()" style="background:#6c757d;">✕ Limpar</button>
            </div>
        </div>
        <div id="resultadosBusca"></div>
    </div>

    <div id="sobre" class="tab-content">
        <div class="sobre-container">
            <h2>👩‍🔬 Sobre o Atlas Hematológico</h2>
            
            <div class="autora-box">
                <div class="foto">🧬</div>
                <div class="info">
                    <h4>Júlia Ribeiro</h4>
                    <span class="badge-autora">📝 Autora do Atlas</span>
                    <p style="margin-top:0.5rem; color:#555;">
                        Estudante Curso Técnico de Análises Clínicas . 
                        Este atlas foi desenvolvido como parte do meu projeto de estudo e pesquisa, 
                        com o objetivo de auxiliar outros estudantes na compreensão da morfologia das 
                        células sanguíneas.
                    </p>
                </div>
            </div>

            <h3>🎯 Por que este Atlas?</h3>
            <p>
                A hematologia é uma área fundamental para o diagnóstico clínico, e a identificação 
                correta das células sanguíneas é uma habilidade essencial para profissionais da saúde. 
                Este atlas digital foi criado para:
            </p>
            <ul style="margin:0.5rem 0 1rem 1.5rem; color:#444;">
                <li><strong>📚 Facilitar o aprendizado:</strong> Reunir informações morfológicas, funcionais e clínicas em um só lugar.</li>
                <li><strong>🔬 Complementar a prática:</strong> Oferecer imagens de referência e descrições detalhadas para auxiliar na identificação celular.</li>
                <li><strong>🧪 Integrar teoria e prática:</strong> Com o quiz interativo, os alunos podem testar seus conhecimentos e receber feedback imediato.</li>
                <li><strong>💡 Estimular a pesquisa:</strong> A central de estudos permite busca inteligente por características e funções celulares.</li>
            </ul>

            <div class="citacao">
                A hematologia é a ponte entre a ciência básica e a prática clínica. 
                Compreender a morfologia celular é o primeiro passo para um diagnóstico preciso.
            </div>

            <h3>📖 Conteúdo do Atlas</h3>
            <p>
                O atlas aborda desde os fundamentos da hematopoiese até as alterações morfológicas 
                das células sanguíneas, com ênfase em:
            </p>
            <ul style="margin:0.5rem 0 1rem 1.5rem; color:#444;">
                <li><strong>Séries celulares:</strong> Eritroide, Granulocítica, Monocítica, Linfocítica e Megacariocítica.</li>
                <li><strong>Células maduras:</strong> Hemácias, leucócitos (neutrófilos, eosinófilos, basófilos, linfócitos, monócitos) e plaquetas.</li>
                <li><strong>Alterações morfológicas:</strong> Anisocitose, poiquilocitose, hipocromia, entre outras.</li>
                <li><strong>Contexto clínico:</strong> Importância diagnóstica de cada alteração observada.</li>
            </ul>

            <h3>🔗 Atlas Original</h3>
            <p>
                Este é um projeto acadêmico desenvolvido para fins educacionais. O atlas original, 
                com conteúdo mais completo e imagens de alta resolução, pode ser acessado no link abaixo:
            </p>
            <a href="Atlas/atlas hematoogico.pdf" class="btn-atlas-original" onclick="alert('Aqui seria o link para o atlas original. Ex: https://atlas-hematologico.com.br')">
                🌐 Acessar Atlas Original
            </a>

            <h3 style="margin-top:2rem;">📝 Créditos</h3>
            <p>
                <strong>Conteúdo científico:</strong> Júlia Ribeiro<br>
                <strong>Desenvolvimento do site:</strong> Natanael Lucas<br>
            </p>
            <p style="font-size:0.85rem; color:#888; margin-top:1rem;">
                Este site é um projeto acadêmico sem fins lucrativos. As imagens são utilizadas para fins educacionais.
            </p>
        </div>
    </div>
</div>

<footer>
    <p>🧬 Atlas Hematológico - Júlia Ribeiro</p>
    <p>Conteúdo científico baseado em literatura hematológica</p>
    <p>Site acadêmico desenvolvido por Natanael Lucas</p>
</footer>

<div id="modal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close-modal" onclick="fecharModal()">&times;</span>
            <h2 id="modalTitulo"></h2>
        </div>
        <div class="modal-body">
            <img id="modalImg" class="modal-img" src="" alt="" />
            <p id="modalConteudo"></p>
            <button class="video-btn-modal" id="modalVideoBtn">▶️ Assistir Vídeo Explicativo</button>
        </div>
    </div>
</div>

<div id="videoModal" class="modal">
    <div class="modal-content video-modal-content" style="background: #000; max-width: 900px; padding: 0; border-radius: 16px; overflow: hidden; position: relative;">
        <span class="close-video" onclick="fecharVideoModal()" style="position: absolute; top: 10px; right: 20px; font-size: 2rem; cursor: pointer; color: white; z-index: 20; background: rgba(0,0,0,0.5); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.2s;">&times;</span>
        <div class="video-wrapper" style="position: relative; padding-bottom: 56.25%; height: 0;" id="videoWrapper"></div>
    </div>
</div>

<script>
// ==============================================
// DADOS DO ATLAS - COM VÍDEOS LOCAIS
// ==============================================
const cards = [
    // ===== INTRODUÇÃO E FUNDAMENTOS =====
    {
        id: 'intro',
        numero: '1',
        titulo: 'Introdução à Hematologia',
        categoria: 'Fundamentos',
        conteudo: 'A hematologia é um ramo da ciência responsável pelo estudo do sangue e seus componentes, incluindo eritrócitos, leucócitos e plaquetas, bem como suas funções e alterações em condições fisiológicas e patológicas. Essa área possui grande relevância no diagnóstico laboratorial, já que auxilia o diagnóstico de condições como anemias, infecções e doenças hematológicas que podem ser identificadas por meio da análise sanguínea. (VIVAS, Wanessa Lordêlo P. S.D.; GRUPO HERMES PARDINI, 2025)\nA análise morfológica das células sanguíneas, realizada principalmente por meio da microscopia, permite avaliar características como tamanho, forma e coloração celular. Essas observações são fundamentais para a identificação de alterações que podem indicar diferentes patologias, contribuindo diretamente para a tomada de decisões clínicas e para o acompanhamento de pacientes. (GRUPO HERMES PARDINI, 2025; ONCOCLÍNICAS, S.D.)',
        palavras_chave: 'sangue, eritrócitos, leucócitos, plaquetas, diagnóstico, anemias, infecções, microscopia, morfológica',
        imagem: 'https://tse3.mm.bing.net/th/id/OIP.uRyQM5fFPhUdkVFeQ_PzKQHaE8?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: 'videos/Introdução_Hematologia.mp4',
        video_tipo: 'local'
    },
    {
        id: 'hematopoiese',
        numero: '2',
        titulo: 'Hematopoiese',
        categoria: 'Formação Celular',
        conteudo: 'A palavra hematopoiese significa formação das células do sangue. É o estudo de todos os fenômenos relacionados com a origem, com a multiplicação e a maturação das células primordiais ou precursora das células sanguíneas. A hematopoiese se divide em dois períodos:\n1º Período Embrionário e Fetal. que acompanha os órgãos hematopoieticos iniciais, como o fígado o baso os nodos linfáticos e na segunda fase embrionaria, a medula óssea;\n2º Período: Pós-natal. Logo após o nascimento, a hematopoiese no fígado, e a medula passa a ser o único local de produção de eritrócitos, granulócitos e plaquetas.\nAo nascer o espaço medular total é ocupado pela medula vermelha; na infância apenas parte desse espaço será necessária para a hematopoiese; o espaço restante fica ocupado pelas células de gordura. Mais tarde apenas os ossos chatos (crânio, vértebras, caixa torácica, ombro e pelve) e as partes proximais dos ossos longos (fêmures e úmeros) serão locais de formação de sangue.',
        palavras_chave: 'formação, diferenciação, medula óssea, embrionário, fetal, pós-natal, ossos chatos, hematopoiese ativa',
        imagem: 'https://biologydictionary.net/wp-content/uploads/2017/06/Hematopoiesis-human-diagram-300x197.jpg',
        video_id: 'videos/Hematopoiese.mp4',
        video_tipo: 'local'
    },
    
    // ===== SÉRIE ERITROIDE - TODOS COM O MESMO VÍDEO LOCAL =====
    {
        id: 'proeritroblasto',
        numero: '2.1.1',
        titulo: 'Proeritroblasto',
        categoria: 'Série Eritroide',
        conteudo: '• <b>Características morfológicas: </b>O proeritroblasto é a maior célula da série eritroide, apresentando elevada relação núcleo/citoplasma. Possui núcleo volumoso, central, com cromatina fina e frouxa, além de um ou mais nucléolos evidentes, indicando intensa atividade transcricional. O citoplasma é intensamente basofílico devido à alta concentração de RNA ribossômico, refletindo intensa síntese proteica, especialmente de cadeias globínicas que compõem a hemoglobina.\n• <b>Etapa da diferenciação:</b> Corresponde à primeira célula morfologicamente identificável da eritropoiese, marcando o início do processo de maturação eritroide na medula óssea.',
        palavras_chave: 'maior célula, núcleo volumoso, cromatina fina, nucléolos evidentes, basofílico, RNA ribossômico, primeira célula, eritropoiese',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/proeritroblasto_4_z.jpg',
        video_id: 'videos/ERITROBLASTOS.mp4',
        video_tipo: 'local'
    },
    {
        id: 'eritroblasto_basofilico',
        numero: '2.1.2',
        titulo: 'Eritroblasto Basofílico',
        categoria: 'Série Eritroide',
        conteudo: '• <b>Características morfológicas:</b> Apresenta redução do tamanho celular em relação ao proeritroblasto, mantendo ainda elevada relação núcleo/citoplasma. O núcleo torna-se mais condensado, com cromatina mais densa e ausência de nucléolos visíveis. O citoplasma permanece fortemente basofílico devido à abundância de RNA, indicando continuidade da atividade sintética, com início progressivo da produção de hemoglobina.\n•<b> Etapa da diferenciação:</b> Fase inicial da maturação eritroide, caracterizada pela manutenção da síntese de proteínas e início da hemoglobinização.',
        palavras_chave: 'redução, tamanho, núcleo condensado, cromatina densa, ausência de nucléolos, basofílico, RNA, síntese de proteínas, hemoglobinização',
        imagem: 'https://files.cercomp.ufg.br/weby/up/756/o/46_-_Eritroblasto_bas%C3%B3filo(seta)_e_eritroblasto_ortocrom%C3%A1tico_(seta_tracejada).jpg',
        video_id: 'videos/ERITROBLASTOS.mp4',
        video_tipo: 'local'
    },
    {
        id: 'eritroblasto_policromatico',
        numero: '2.1.3',
        titulo: 'Eritroblasto Policromático',
        categoria: 'Série Eritroide',
        conteudo: '• <b>Características morfológicas:</b> Célula de tamanho intermediário, com citoplasma apresentando coloração mista (policromasia), resultante da combinação entre a basofilia do RNA e a acidofilia da hemoglobina recém-sintetizada. O núcleo apresenta cromatina progressivamente condensada, com aspecto mais escuro e sem nucléolos.\n• <b>Etapa da diferenciação: </b>Fase intermediária da eritropoiese, marcada por intensa síntese de hemoglobina e redução da atividade nuclear.',
        palavras_chave: 'tamanho intermediário, coloração mista, policromasia, basofilia, acidofilia, hemoglobina, cromatina condensada, síntese de hemoglobina',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Policromatico16.jpg',
        video_id: 'videos/ERITROBLASTOS.mp4',
        video_tipo: 'local'
    },
    {
        id: 'eritroblasto_ortocromatico',
        numero: '2.1.4',
        titulo: 'Eritroblasto Ortocromático',
        categoria: 'Série Eritroide',
        conteudo: '• <b>Características morfológicas:</b> Apresenta tamanho reduzido e citoplasma predominantemente acidofílico, devido à elevada concentração de hemoglobina. O núcleo encontra-se altamente condensado (picnótico), pequeno e escuro, prestes a ser eliminado da célula.\n• <b>Etapa da diferenciação:</b> Última fase nucleada da eritropoiese, antecedendo a extrusão do núcleo e a formação do reticulócito.',
        palavras_chave: 'tamanho reduzido, acidofílico, hemoglobina, núcleo picnótico, condensado, eliminação do núcleo, última fase, reticulócito',
        imagem: 'https://files.cercomp.ufg.br/weby/up/756/o/17-_Eritroblasto_expulsando_o_n%C3%BAcleo.jpg',
        video_id: 'videos/ERITROBLASTOS.mp4',
        video_tipo: 'local'
    },
    {
        id: 'reticulocito',
        numero: '2.1.5',
        titulo: 'Reticulócito',
        categoria: 'Série Eritroide',
        conteudo: '• <b>Características morfológicas:</b> Célula anucleada, com morfologia semelhante à hemácia madura, porém com citoplasma levemente basofílico devido à presença de restos de RNA ribossômico. Esses resíduos podem ser evidenciados por colorações supravitais, formando uma rede (retículo) característica.\n• <b>Etapa da diferenciação:</b> Estágio final da eritropoiese, sendo liberado na circulação periférica, onde completa sua maturação em eritrócito em aproximadamente 24 a 48 horas.',
        palavras_chave: 'anucleada, hemácia madura, basofílico, RNA ribossômico, colorações supravitais, retículo, estágio final, circulação periférica, 24 a 48 horas',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Reticul%C3%B3citos_100x_2_z.jpg',
        video_id: 'videos/ERITROBLASTOS.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA SÉRIE ERITROIDE
    {
        id: 'ref_eritroide',
        titulo: 'Referências - Série Eritroide',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Wintrobe, M. M.</strong> Clinical Hematology. 13th ed. Philadelphia: Wolters Kluwer, 2014.</li><li><strong>BRASIL. Ministério da Saúde.</strong> Manual de Hematologia. Brasília, 2010.</li></ul>',
        palavras_chave: 'referências, bibliografia, série eritroide, eritropoiese, hemácia, proeritroblasto, eritroblasto, reticulócito',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    },

    // ===== SÉRIE GRANULOCÍTICA - COM VÍDEOS LOCAIS =====
    {
        id: 'mieloblasto',
        numero: '2.2.1',
        titulo: 'Mieloblasto',
        categoria: 'Série Granulocítica',
        conteudo: '• <b>Características morfológicas:</b> O mieloblasto é uma célula de grande tamanho, com elevada relação núcleo/citoplasma. Apresenta núcleo volumoso, geralmente arredondado ou oval, com cromatina fina e frouxa, além da presença de dois a cinco nucléolos evidentes. O citoplasma é escasso, intensamente basofílico e desprovido de grânulos, refletindo estágio inicial de diferenciação e alta atividade metabólica.\n• <b>Etapa da diferenciação:</b> Corresponde à primeira célula morfologicamente identificável da série granulocítica, dando início ao processo de formação dos granulócitos.',
        palavras_chave: 'grande tamanho, relação núcleo/citoplasma, núcleo volumoso, arredondado, cromatina fina, nucléolos evidentes, basofílico, sem grânulos, primeira célula',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Mieloblasto_z.jpg',
        video_id: 'videos/Mieloblastos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'promielocito',
        numero: '2.2.2',
        titulo: 'Promielócito',
        categoria: 'Série Granulocítica',
        conteudo: '• <b>Características morfológicas: </b>Apresenta aumento do citoplasma em relação ao mieloblasto e início da formação de grânulos primários (azurófilos), que contêm enzimas lisossomais importantes para a função celular. O núcleo ainda é grande, com cromatina levemente mais condensada, podendo apresentar nucléolos pouco evidentes.\n• <b>Etapa da diferenciação:</b> Fase inicial da maturação granulocítica, caracterizada pela síntese de grânulos primários.',
        palavras_chave: 'aumento do citoplasma, grânulos primários, azurófilos, enzimas lisossomais, nucléolos pouco evidentes, síntese de grânulos',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/promielocito_2.jpg',
        video_id: 'videos/Promielocito.mp4',
        video_tipo: 'local'
    },
    {
        id: 'mielocito',
        numero: '2.2.3',
        titulo: 'Mielócito',
        categoria: 'Série Granulocítica',
        conteudo: '• <b>Características morfológicas:</b> Célula com núcleo mais condensado, geralmente excêntrico, sem nucléolos visíveis. O citoplasma torna-se mais abundante e apresenta grânulos específicos, marcando o início da diferenciação entre neutrófilos, eosinófilos e basófilos. A coloração do citoplasma varia conforme o tipo celular em desenvolvimento.\n•<b>Etapa da diferenciação:</b> Fase de diferenciação específica da linhagem granulocítica.',
        palavras_chave: 'núcleo condensado, excêntrico, sem nucléolos, grânulos específicos, diferenciação, neutrófilos, eosinófilos, basófilos',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/mielocito.jpg',
        video_id: 'videos/Mielócito.mp4',
        video_tipo: 'local'
    },
    {
        id: 'metamielocito',
        numero: '2.2.4',
        titulo: 'Metamielócito',
        categoria: 'Série Granulocítica',
        conteudo: '• <b>Características morfológicas:</b> Apresenta núcleo em formato de rim ou ferradura, com cromatina mais condensada. O citoplasma contém grande quantidade de grânulos específicos bem desenvolvidos, característicos do tipo de granulócito em formação.\n• <b>Etapa da diferenciação:</b> Fase avançada da maturação, com redução da atividade proliferativa.',
        palavras_chave: 'núcleo em rim, ferradura, cromatina condensada, grânulos específicos, maturação avançada, redução da proliferação',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Metamielocito_z.jpg',
        video_id: 'videos/metamielocito.mp4',
        video_tipo: 'local'
    },
    {
        id: 'bastonete',
        numero: '2.2.5',
        titulo: 'Neutrófilo Bastonete',
        categoria: 'Série Granulocítica',
        conteudo: '• <b>Características morfológicas:</b> Célula com núcleo alongado em forma de bastão ou ferradura, sem segmentação completa. O citoplasma apresenta grânulos específicos, semelhantes aos da célula madura, indicando estágio avançado de diferenciação.\n• <b>Etapa da diferenciação: </b>Penúltima fase da granulocitopoiese, antecedendo a formação da célula madura.\n• Importância clínica: O aumento de neutrófilos bastonetes no sangue periférico, conhecido como "desvio à esquerda", está associado a infecções agudas e processos inflamatórios intensos.',
        palavras_chave: 'núcleo alongado, bastão, ferradura, sem segmentação, penúltima fase, desvio à esquerda, infecção aguda',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/bastao_8.jpg',
        video_id: 'videos/Bastonetes.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA SÉRIE GRANULOCÍTICA
    {
        id: 'ref_granulocitica',
        titulo: 'Referências - Série Granulocítica',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Kaushansky, K.; Lichtman, M. A.</strong> Williams Hematology. 10th ed. New York: McGraw-Hill, 2021.</li><li><strong>Ferreira, A. W.; Ávila, S. L. M.</strong> Hematologia Básica. Rio de Janeiro: Guanabara Koogan, 2008.</li></ul>',
        palavras_chave: 'referências, bibliografia, série granulocítica, granulopoiese, mieloblasto, promielócito, neutrófilo, eosinófilo, basófilo',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    },

    // ===== SÉRIE MONOCÍTICA =====
    {
        id: 'monoblasto',
        numero: '2.3.1',
        titulo: 'Monoblasto',
        categoria: 'Série Monocítica',
        conteudo: '• <b>Características morfológicas:</b> Célula de grande tamanho, com núcleo volumoso, geralmente arredondado, cromatina frouxa e presença de nucléolos evidentes. O citoplasma é basofílico e relativamente abundante, indicando intensa atividade metabólica.\n• <b>Etapa da diferenciação: </b>Primeira célula da linhagem monocítica.',
        palavras_chave: 'grande tamanho, núcleo volumoso, arredondado, cromatina frouxa, nucléolos evidentes, basofílico, primeira célula, monócitos',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/monoblasto.jpg',
        video_id: 'videos/MONOCITOS-X-PROMONOCITOS-X-MONOBLASTOS.mp4',
        video_tipo: 'local'
    },
    {
        id: 'promonocito',
        numero: '2.3.2',
        titulo: 'Promonócito',
        categoria: 'Série Monocítica',
        conteudo: '• <b>Características morfológicas:</b> Apresenta núcleo irregular ou levemente dobrado, com cromatina mais condensada. O citoplasma torna-se mais abundante, podendo apresentar vacúolos e granulações finas.\n• <b>Etapa da diferenciação:</b> Fase intermediária da maturação monocítica.',
        palavras_chave: 'núcleo irregular, dobrado, cromatina condensada, vacúolos, granulações finas, maturação monocítica',
        imagem: 'https://tse3.mm.bing.net/th/id/OIP.l2do8Y3rVvWVpOOA7fvFWgAAAA?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: 'videos/MONOCITOS-X-PROMONOCITOS-X-MONOBLASTOS.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA SÉRIE MONOCÍTICA
    {
        id: 'ref_monocitica',
        titulo: 'Referências - Série Monocítica',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Kaushansky, K.; Lichtman, M. A.</strong> Williams Hematology. 10th ed. New York: McGraw-Hill, 2021.</li><li><strong>Lorenzi, T. F.</strong> Manual de Hematologia: Morfologia e Fisiologia. São Paulo: Roca, 2005.</li></ul>',
        palavras_chave: 'referências, bibliografia, série monocítica, monoblasto, promonócito, monócito, macrófago',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    },

    // ===== SÉRIE LINFOCÍTICA =====
    {
        id: 'linfoblasto',
        numero: '2.4.1',
        titulo: 'Linfoblasto',
        categoria: 'Série Linfocítica',
        conteudo: '• <b>Características morfológicas:</b> Célula grande, com núcleo volumoso, cromatina frouxa e presença de nucléolos visíveis. O citoplasma é escasso e intensamente basofílico, indicando elevada atividade metabólica.\n• <b>Etapa da diferenciação:</b> Primeira célula da linhagem linfocítica.',
        palavras_chave: 'célula grande, núcleo volumoso, cromatina frouxa, nucléolos visíveis, basofílico, linfócitos T, linfócitos B',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/linfoblasto_3.jpg',
        video_id: 'videos/linfoblastos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'prolinfocito',
        numero: '2.4.2',
        titulo: 'Pró-linfócito',
        categoria: 'Série Linfocítica',
        conteudo: '• <b>Características morfológicas:</b> Célula menor, com núcleo ainda predominante, porém com cromatina mais condensada. O citoplasma é discreto e levemente basofílico.\n• <b>Etapa da diferenciação:</b> Fase intermediária da maturação linfocítica.',
        palavras_chave: 'célula menor, núcleo predominante, cromatina condensada, basofílico, maturação linfocítica',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/11.jpg',
        video_id: 'videos/prolinfocitos.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA SÉRIE LINFOCÍTICA
    {
        id: 'ref_linfocitica',
        titulo: 'Referências - Série Linfocítica',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Abbas, A. K.; Lichtman, A. H.</strong> Imunologia Celular e Molecular. 9. ed. Rio de Janeiro: Elsevier, 2019.</li><li><strong>Kaushansky, K.; Lichtman, M. A.</strong> Williams Hematology. 10th ed. New York: McGraw-Hill, 2021.</li></ul>',
        palavras_chave: 'referências, bibliografia, série linfocítica, linfoblasto, pró-linfócito, linfócito, linfócito T, linfócito B',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    },

    // ===== SÉRIE MEGACARIOCÍTICA =====
    {
        id: 'megacarioblasto',
        numero: '2.5.1',
        titulo: 'Megacarioblasto',
        categoria: 'Série Megacariocítica',
        conteudo: '• <b>Características morfológicas:</b> O megacarioblasto é uma célula de grande tamanho, com núcleo volumoso, cromatina frouxa e presença de nucléolos evidentes. O citoplasma é basofílico e relativamente escasso, refletindo intensa atividade metabólica inicial.\n• <b>Etapa da diferenciação:</b> Primeira célula da série megacariocítica, responsável por dar origem às células formadoras de plaquetas.',
        palavras_chave: 'grande tamanho, núcleo volumoso, cromatina frouxa, nucléolos evidentes, basofílico, plaquetas',
        imagem: 'https://1.bp.blogspot.com/-WQBG91v112Y/VfKF1YekoFI/AAAAAAAAADk/aud0O__wrN0/s320/megacarioblasto4.jpg',
        video_id: 'videos/megacarioblasto.mp4',
        video_tipo: 'local'
    },
    {
        id: 'promegacariocito',
        numero: '2.5.2',
        titulo: 'Promegacariócito',
        categoria: 'Série Megacariocítica',
        conteudo: '• <b>Características morfológicas: </b>O promegacariócito apresenta aumento significativo do tamanho celular e do citoplasma. O núcleo torna-se irregular e inicia o processo de lobulação, acompanhado do aumento do conteúdo de DNA por meio da endomitose. O citoplasma torna-se mais abundante e granular.\n• <b>Etapa da diferenciação: </b>Fase intermediária da megacariopoiese, caracterizada pelo crescimento celular e preparação para a formação de plaquetas.',
        palavras_chave: 'aumento do tamanho, núcleo irregular, lobulação, endomitose, DNA, megacariopoiese',
        imagem: 'https://1.bp.blogspot.com/-c1lXLo_ZSmQ/VDKgUcA5NfI/AAAAAAAAAJA/cmw-CmgVyVs/s1600/pro.jpg',
        video_id: 'videos/megariocito.mp4',
        video_tipo: 'local'
    },
    {
        id: 'megacariocito',
        numero: '2.5.3',
        titulo: 'Megacariócito',
        categoria: 'Série Megacariocítica',
        conteudo: '• <b>Características morfológicas:</b> O megacariócito é uma célula gigante da medula óssea, apresentando núcleo multilobulado e altamente poliploide. O citoplasma é abundante e apresenta áreas que darão origem às plaquetas por fragmentação.\n• <b>Etapa da diferenciação: </b>Fase final da megacariopoiese, responsável pela produção e liberação de plaquetas para a circulação sanguínea.',
        palavras_chave: 'célula gigante, núcleo multilobulado, poliploide, fragmentação, plaquetas, megacariopoiese',
        imagem: 'https://th.bing.com/th/id/R.f6fad53c15f221fc1efcd48f406b9468?rik=0nWU56qfTy9F9Q&riu=http%3a%2f%2ffiles.cercomp.ufg.br%2fweby%2fup%2f486%2fo%2fmegacari%c3%b3cito_1.jpg&ehk=IGukF2W%2bd6IRnvd5KoT%2foeCnSbOl4fW9rs%2fwgCnxCfg%3d&risl=&pid=ImgRaw&r=0',
        video_id: 'videos/megariocito.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA SÉRIE MEGACARIOCÍTICA
    {
        id: 'ref_megacariocitica',
        titulo: 'Referências - Série Megacariocítica',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Kaushansky, K.; Lichtman, M. A.</strong> Williams Hematology. 10th ed. New York: McGraw-Hill, 2021.</li><li><strong>Machado, C. A.</strong> Hematologia e Hemoterapia. São Paulo: Editora Senac, 2015.</li></ul>',
        palavras_chave: 'referências, bibliografia, série megacariocítica, megacarioblasto, promegacariócito, megacariócito, plaqueta',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    },

    // ===== SANGUE PERIFÉRICO =====
    {
        id: 'sangue_periferico',
        numero: '3',
        titulo: 'Sangue Periférico (Células Maduras)',
        categoria: 'Fundamentos',
        conteudo: 'O sangue periférico é composto pelos elementos figurados (eritrócitos, leucócitos e plaquetas) suspensos no plasma, desempenhando funções essenciais para a manutenção do organismo. A análise dessas células, especialmente por meio do exame microscópico, permite avaliar suas características morfológicas e identificar possíveis alterações relacionadas a diversas condições clínicas. A observação das células maduras no sangue periférico é fundamental para o diagnóstico laboratorial, uma vez que alterações em sua quantidade, forma ou função podem indicar doenças hematológicas, infecciosas ou inflamatórias. Dessa forma, o estudo dessas células contribui diretamente para a compreensão do estado de saúde do indivíduo. (AQUINO, ano; GRUPO HERMES PARDINI, 2025)',
        palavras_chave: 'sangue periférico, eritrócitos, leucócitos, plaquetas, plasma, microscopia, diagnóstico, hematológicas, infecciosas, inflamatórias',
        imagem: 'https://files.passeidireto.com/4a9e2f0d-a8dd-44f5-9026-f7db15109ee6/4a9e2f0d-a8dd-44f5-9026-f7db15109ee6.png',
        video_id: 'videos/sangue_periferica.mp4',
        video_tipo: 'local'
    },
    {
        id: 'hemacia',
        numero: '3.1.1',
        titulo: 'Hemácia (Eritrócito)',
        categoria: 'Série Eritrocitária',
        conteudo: '• <b>Características morfológicas: </b>As hemácias são células anucleadas, com formato de disco bicôncavo, o que aumenta sua área de superfície em relação ao volume, facilitando as trocas gasosas. Apresentam citoplasma acidofílico, rico em hemoglobina, proteína responsável pelo transporte de oxigênio e dióxido de carbono. Possuem uma região central mais clara, conhecida como zona de palidez central, característica importante para sua identificação em esfregaços sanguíneos.\n• <b>Função:</b> Sua principal função é o transporte de oxigênio dos pulmões para os tecidos e de dióxido de carbono dos tecidos para os pulmões, participando diretamente do processo respiratório e do equilíbrio ácido-base do organismo.\n• <b>Importância clínica:</b> As hemácias constituem um dos principais indicadores laboratoriais do estado hematológico do indivíduo. Alterações em sua morfologia, como variações no tamanho (anisocitose), forma (poiquilocitose) e coloração (hipocromia), podem refletir distúrbios na eritropoiese ou na síntese de hemoglobina, sendo fundamentais para a identificação e classificação das anemias e outras condições sistêmicas.',
        palavras_chave: 'anucleadas, disco bicôncavo, trocas gasosas, acidofílico, hemoglobina, zona de palidez central, transporte de oxigênio, dióxido de carbono, anemias',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Ham%C3%A1cias_normais_z.jpg',
        video_id: 'videos/Hemacias.mp4',
        video_tipo: 'local'
    },
    {
        id: 'neutrofilo_segmentado',
        numero: '3.2.1',
        titulo: 'Neutrófilo Segmentado',
        categoria: 'Série Leucocitária',
        conteudo: '• <b>Características morfológicas:</b> O neutrófilo segmentado apresenta núcleo dividido em dois a cinco lóbulos, interligados por finos filamentos de cromatina. O citoplasma contém grânulos finos e pouco evidentes, que armazenam enzimas importantes para a destruição de microrganismos.\n• <b>Função:</b> Atua principalmente na defesa do organismo por meio da fagocitose, sendo uma das primeiras células a chegar ao local de infecção.\n• <b>Importância clínica: </b>Os neutrófilos são marcadores importantes de resposta inflamatória aguda. Alterações em sua contagem ou morfologia podem indicar processos infecciosos, inflamatórios ou alterações na medula óssea, sendo amplamente utilizados na avaliação clínica de infecções e estados de estresse fisiológico.',
        palavras_chave: 'núcleo dividido, lóbulos, filamentos, grânulos finos, fagocitose, infecções, inflamatória aguda',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Neut_seg_zz.jpg',
        video_id: 'videos/Neutrófilos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'eosinofilo',
        numero: '3.2.2',
        titulo: 'Eosinófilo',
        categoria: 'Série Leucocitária',
        conteudo: '• <b>Características morfológicas:</b> Apresenta núcleo bilobulado e citoplasma com grânulos grandes e acidofílicos, que se coram intensamente em tons alaranjados ou avermelhados.\n• <b>Função:</b> Está envolvido na resposta contra parasitas e em reações alérgicas, atuando na modulação da resposta inflamatória.\n• <b>Importância clínica:</b> A elevação dos eosinófilos pode estar associada a processos alérgicos, infecções parasitárias e doenças inflamatórias. Sua avaliação auxilia na investigação de respostas imunológicas exacerbadas e condições alérgicas.',
        palavras_chave: 'núcleo bilobulado, grânulos acidofílicos, alaranjados, avermelhados, parasitas, reações alérgicas, processos alérgicos, infecções parasitárias',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Eosinofilo_100x_2_z.jpg',
        video_id: 'videos/eosinofilo.mp4',
        video_tipo: 'local'
    },
    {
        id: 'basofilo',
        numero: '3.2.3',
        titulo: 'Basófilo',
        categoria: 'Série Leucocitária',
        conteudo: '• <b>Características morfológicas:</b> Possui núcleo irregular ou pouco visível, frequentemente encoberto por numerosos grânulos basofílicos escuros no citoplasma.\n• <b>Função: </b>Participa de reações alérgicas e inflamatórias, liberando substâncias como histamina e heparina.\n• <b>Importância clínica:</b> Embora raros no sangue periférico, os basófilos podem apresentar alterações em situações específicas, como doenças mieloproliferativas e reações de hipersensibilidade, contribuindo para a avaliação de distúrbios hematológicos e imunológicos.',
        palavras_chave: 'núcleo irregular, pouco visível, grânulos basofílicos escuros, histamina, heparina, reações alérgicas, mieloproliferativas',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Basofilo_100x_2_zz.jpg',
        video_id: 'videos/Basofilos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'linfocito',
        numero: '3.2.4',
        titulo: 'Linfócito',
        categoria: 'Série Leucocitária',
        conteudo: '• <b>Características morfológicas:</b> Célula pequena, com núcleo grande, arredondado e cromatina densa, ocupando a maior parte do volume celular. O citoplasma é escasso, formando um fino halo ao redor do núcleo.\n• <b>Função: </b>Os linfócitos são responsáveis pela resposta imunológica específica e podem ser classificados principalmente em linfócitos B e linfócitos T. Linfócitos B atuam na imunidade humoral, sendo responsáveis pela produção de anticorpos. Linfócitos T atuam na imunidade celular, participando da destruição de células infectadas e da regulação da resposta imunológica.\n• <b>Importância clínica:</b> A avaliação dos linfócitos é fundamental na análise do sistema imunológico. Alterações em sua quantidade ou morfologia podem indicar infecções, principalmente virais, além de estarem associadas a doenças autoimunes e neoplasias hematológicas.',
        palavras_chave: 'célula pequena, núcleo grande, arredondado, cromatina densa, anticorpos, imunidade humoral, imunidade celular, resposta imunológica',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Linfocito_100x_2_z.jpg',
        video_id: 'videos/Linfocitos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'monocito',
        numero: '3.2.5',
        titulo: 'Monócito',
        categoria: 'Série Leucocitária',
        conteudo: '• <b>Características morfológicas:</b> É a maior célula do sangue periférico, com núcleo em formato de rim ou ferradura e citoplasma abundante, de coloração cinza-azulada, podendo apresentar vacúolos.\n•<b> Função:</b> Atua na fagocitose e na apresentação de antígenos, sendo fundamental na resposta imunológica.\n•<b> Importância clínica:</b> Os monócitos estão associados a processos inflamatórios crônicos e infecções persistentes. Sua avaliação auxilia na identificação de alterações imunológicas e na investigação de doenças infecciosas e inflamatórias de longa duração.',
        palavras_chave: 'maior célula, núcleo em rim, ferradura, cinza-azulado, fagocitose, antígenos, macrófagos, inflamatórios crônicos',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/monocito_2.jpg',
        video_id: 'videos/Monocitos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'plaquetas',
        numero: '3.3.1',
        titulo: 'Plaquetas',
        categoria: 'Série Plaquetária',
        conteudo: '• <b>Características morfológicas:</b> As plaquetas são fragmentos citoplasmáticos anucleados derivados dos megacariócitos, apresentando formato irregular e pequeno tamanho. Possuem regiões distintas relacionadas à sua função, incluindo áreas ricas em grânulos.\n•<b> Função:</b> Desempenham papel fundamental na hemostasia, participando da formação do tampão plaquetário e na ativação da cascata de coagulação.\n• <b>Importância clínica:</b> A avaliação das plaquetas é essencial para a investigação de distúrbios hemorrágicos e trombóticos. Alterações em sua quantidade ou função podem indicar problemas na medula óssea, doenças sistêmicas ou alterações nos mecanismos de coagulação.',
        palavras_chave: 'fragmentos citoplasmáticos, anucleados, megacariócitos, hemostasia, tampão plaquetário, coagulação, hemorrágicos, trombóticos',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/plaquetas_norm__40x_1.jpg',
        video_id: 'videos/Plaquetas.mp4',
        video_tipo: 'local'
    },

    // ===== ALTERAÇÕES MORFOLÓGICAS =====
    {
        id: 'alteracoes_morfologicas',
        numero: '4',
        titulo: 'Alterações Morfológicas',
        categoria: 'Alterações',
        conteudo: 'As alterações morfológicas das células sanguíneas correspondem a modificações estruturais observadas principalmente nas hemácias, envolvendo aspectos como tamanho, forma e coloração. Essas alterações são identificadas por meio da análise microscópica do esfregaço sanguíneo, sendo fundamentais para a avaliação da integridade celular e do funcionamento adequado da hematopoiese.\nEssas modificações refletem, na maioria das vezes, distúrbios nos processos de produção, maturação ou sobrevivência das células sanguíneas, podendo estar relacionadas a deficiências nutricionais, alterações genéticas, processos inflamatórios ou doenças hematológicas. Dessa forma, a análise morfológica não apenas complementa os dados quantitativos do hemograma, mas também fornece informações qualitativas essenciais para o diagnóstico laboratorial.\nAlém disso, o reconhecimento dessas alterações permite identificar padrões característicos associados a determinadas patologias, auxiliando na diferenciação entre tipos de anemia e outras condições clínicas, o que torna essa análise uma ferramenta indispensável na prática das análises clínicas. (AQUINO, ano; GRUPO HERMES PARDINI, 2025)',
        palavras_chave: 'alterações morfológicas, hemácias, tamanho, forma, coloração, microscopia, esfregaço sanguíneo, hematopoiese, deficiências nutricionais, genéticas, inflamatórias, anemias',
        imagem: 'https://atlashematologia.ufsc.br/conteudo/anemias_hemoliticas/diagnostico_laboratorial_15/Figura%2015.2.JPG',
        video_id: 'videos/Alteraçao_morfologicas.mp4',
        video_tipo: 'local'
    },
    {
        id: 'anisocitose',
        numero: '4.1.1',
        titulo: 'Anisocitose',
        categoria: 'Alterações de Tamanho',
        conteudo: '• <b>Características morfológicas:</b> A anisocitose caracteriza-se pela presença de hemácias com variações significativas de tamanho no mesmo esfregaço sanguíneo, evidenciando uma população eritrocitária heterogênea. Observa-se a coexistência de hemácias microcíticas e macrocíticas, o que compromete a uniformidade celular normalmente esperada. Essa variação pode ser percebida tanto visualmente quanto por índices hematimétricos.\n• <b>Interpretação:</b> Essa alteração está diretamente relacionada a distúrbios na eritropoiese, refletindo irregularidade na produção e maturação das hemácias pela medula óssea. Pode ocorrer em situações em que há deficiência de nutrientes essenciais, como ferro, vitamina B12 ou ácido fólico.\n• <b>Importância clínica:</b> A anisocitose é um achado frequente em diversas condições hematológicas, especialmente em anemias, sendo um importante indicativo de heterogeneidade celular. Sua identificação contribui para a investigação da causa da anemia e para a avaliação da resposta da medula óssea ao tratamento.',
        palavras_chave: 'variações de tamanho, microcíticas, macrocíticas, eritropoiese, deficiência de ferro, vitamina B12, ácido fólico, anemias',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Anisocitose_z1.jpg',
        video_id: 'videos/anisocitose.mp4',
        video_tipo: 'local'
    },
    {
        id: 'microcitose',
        numero: '4.1.2',
        titulo: 'Microcitose',
        categoria: 'Alterações de Tamanho',
        conteudo: '• <b>Características morfológicas:</b> A microcitose refere-se à presença predominante de hemácias de tamanho reduzido, com diâmetro inferior ao normal. Essas células frequentemente apresentam aumento da palidez central, indicando menor conteúdo de hemoglobina.\n• <b>Interpretação:</b> Essa alteração está associada à diminuição da síntese de hemoglobina durante a formação das hemácias, resultando em células menores e menos eficientes no transporte de oxigênio.\n• <b>Importância clínica:</b> A microcitose é comumente observada em anemias ferroprivas e em distúrbios da síntese de hemoglobina. Sua presença auxilia na classificação das anemias e na identificação de possíveis deficiências nutricionais.',
        palavras_chave: 'tamanho reduzido, palidez central, síntese de hemoglobina, anemias ferroprivas',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Microcitose_zz.jpg',
        video_id: 'videos/Microcitos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'macrocitose',
        numero: '4.1.3',
        titulo: 'Macrocitose',
        categoria: 'Alterações de Tamanho',
        conteudo: '• <b>Características morfológicas:</b> A macrocitose caracteriza-se pela presença de hemácias com tamanho aumentado, apresentando diâmetro superior ao normal. Essas células podem apresentar formato mais arredondado e menor palidez central.\n• <b>Interpretação: </b>Está associada a alterações na maturação celular, geralmente relacionadas a distúrbios na síntese de DNA, o que leva à produção de células maiores e com desenvolvimento incompleto.\n• <b>Importância clínica: </b>É frequentemente observada em anemias megaloblásticas, sendo um importante indicativo de deficiência de vitamina B12 ou ácido fólico, além de outras condições que afetam a divisão celular.',
        palavras_chave: 'tamanho aumentado, arredondado, palidez central, síntese de DNA, anemias megaloblásticas, vitamina B12, ácido fólico',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Microcitose_zz.jpg',
        video_id: 'videos/Macrocitose.mp4',
        video_tipo: 'local'
    },
    {
        id: 'poiquilocitose',
        numero: '4.2.1',
        titulo: 'Poiquilocitose',
        categoria: 'Alterações de Forma',
        conteudo: '• <b>Características morfológicas:</b> A poiquilocitose refere-se à presença de hemácias com formas variadas e anormais no mesmo esfregaço sanguíneo. Essas células podem apresentar formatos irregulares, como alongados, ovais ou deformados, evidenciando alteração na estrutura da membrana celular.\n• <b>Interpretação: </b>Essa alteração indica comprometimento da integridade estrutural das hemácias, podendo resultar de defeitos na membrana ou de processos patológicos que afetam a forma celular.\n• <b>Importância clínica:</b> A poiquilocitose está associada a diversas condições hematológicas, sendo um indicativo importante de alterações na produção ou destruição das hemácias, contribuindo para o diagnóstico diferencial de anemias.',
        palavras_chave: 'formas variadas, anormais, codócitos, estomatócitos, esferócitos, membrana, hematológicas',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Poiquilocitose_2_z.jpg',
        video_id: 'videos/poiquilocitose.mp4',
        video_tipo: 'local'
    },
    {
        id: 'hipocromia',
        numero: '4.2.2',
        titulo: 'Hipocromia',
        categoria: 'Alterações de Coloração',
        conteudo: '• <b>Características morfológicas:</b> A hipocromia caracteriza-se pela diminuição da coloração das hemácias, com aumento da área de palidez central, indicando menor conteúdo de hemoglobina.\n• <b>Interpretação: </b>Reflete deficiência na síntese de hemoglobina durante a eritropoiese, resultando em células menos eficientes no transporte de oxigênio.\n• <b>Importância clínica:</b> É um achado comum em anemias ferroprivas, sendo um importante indicativo de deficiência de ferro ou distúrbios na produção de hemoglobina.',
        palavras_chave: 'diminuição da coloração, palidez central, hemoglobina, síntese de hemoglobina, anemias ferroprivas',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: 'videos/Discromia-Acromia-e-Hipocromia.mp4',
        video_tipo: 'local'
    },
    {
        id: 'drepanocitos',
        numero: '4.2.3',
        titulo: 'Drepanócitos (Hemácias Falciformes)',
        categoria: 'Alterações de Forma',
        conteudo: '• <b>Características morfológicas:</b> Os drepanócitos apresentam formato alongado e curvado, semelhante a uma foice, com extremidades pontiagudas. Essa alteração morfológica compromete a flexibilidade das células.\n• <b>Interpretação:</b> Resultam de alterações estruturais na hemoglobina, que levam à deformação das hemácias em condições específicas, como baixa oxigenação.\n• <b>Importância clínica:</b> São característicos da anemia falciforme e estão associados a alterações na circulação sanguínea, podendo causar obstruções vasculares e prejuízo na oxigenação dos tecidos.',
        palavras_chave: 'foice, extremidades pontiagudas, hemoglobina anormal, HbS, anemia falciforme, obstruções vasculares, oxigenação',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/Drepan%C3%B3citos_100x_z.jpg',
        video_id: 'videos/Drepanocitos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'esferocitos',
        numero: '4.2.4',
        titulo: 'Esferócitos',
        categoria: 'Alterações de Forma',
        conteudo: '• <b>Características morfológicas:</b> Os esferócitos são hemácias que apresentam formato esférico, com redução do diâmetro e ausência da palidez central característica. Apresentam coloração mais intensa devido à maior concentração relativa de hemoglobina.\n• <b>Interpretação:</b> Resultam de alterações na membrana eritrocitária, levando à perda da forma bicôncava e à diminuição da deformabilidade celular.\n• <b>Importância clínica: </b>São frequentemente associados a processos hemolíticos e doenças hereditárias, sendo um importante marcador de alterações na integridade da membrana das hemácias.',
        palavras_chave: 'esféricas, redução do diâmetro, ausência da palidez central, coloração intensa, membrana eritrocitária, hemolíticos, hereditárias',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP._SP1nJLS0xZIkjKzPV_yXQHaF3?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: 'videos/esferocitos.mp4',
        video_tipo: 'local'
    },
    {
        id: 'policromasia',
        numero: '4.2.5',
        titulo: 'Policromasia',
        categoria: 'Alterações de Coloração',
        conteudo: '• <b>Características morfológicas:</b> A policromasia refere-se à presença de hemácias com coloração levemente azulada ou acinzentada, devido à presença de reticulócitos no sangue periférico.\n• <b>Interpretação:</b> Indica aumento da atividade medular e liberação precoce de células jovens na circulação.\n• <b>Importância clínica:</b> Está associada a respostas regenerativas da medula óssea, sendo observada em situações de perda sanguínea ou hemólise, auxiliando na avaliação da atividade eritropoiética.',
        palavras_chave: 'coloração azulada, acinzentada, reticulócitos, células jovens, atividade medular, resposta regenerativa, perda sanguínea, hemólise',
        imagem: 'https://files.cercomp.ufg.br/weby/up/486/o/policromasia_100x_z.jpg',
        video_id: 'videos/policromasia.mp4',
        video_tipo: 'local'
    },
    // REFERÊNCIA ALTERAÇÕES MORFOLÓGICAS
    {
        id: 'ref_alteracoes',
        titulo: 'Referências - Alterações Morfológicas',
        categoria: 'Referências',
        conteudo: '<ul><li><strong>HOFFBRAND, A. V.; MOSS, P. A. H.</strong> Fundamentos em Hematologia. 7. ed. Porto Alegre: Artmed, 2018.</li><li><strong>ZAGO, M. A.; FALCÃO, R. P.; PASQUINI, R.</strong> Hematologia: Fundamentos e Prática. São Paulo: Atheneu, 2013.</li><li><strong>Bain, B. J.</strong> Blood Cells: A Practical Guide. 5th ed. Oxford: Wiley-Blackwell, 2015.</li><li><strong>Wintrobe, M. M.</strong> Clinical Hematology. 13th ed. Philadelphia: Wolters Kluwer, 2014.</li><li><strong>Kaushansky, K.; Lichtman, M. A.</strong> Williams Hematology. 10th ed. New York: McGraw-Hill, 2021.</li><li><strong>Lorenzi, T. F.</strong> Manual de Hematologia: Morfologia e Fisiologia. São Paulo: Roca, 2005.</li></ul>',
        palavras_chave: 'referências, bibliografia, alterações morfológicas, anisocitose, microcitose, macrocitose, poiquilocitose, hipocromia, drepanócitos, esferócitos, policromasia',
        imagem: 'https://tse1.mm.bing.net/th/id/OIP.0gyvRZnOUtAejxu5X22NLAHaFj?rs=1&pid=ImgDetMain&o=7&rm=3',
        video_id: '',
        video_tipo: 'nenhum',
        is_referencia: true
    }
];

// ==============================================
// QUIZ COM 30 QUESTÕES (QUESTÕES BASE)
// ==============================================
const quizQuestionsBase = [
    {
        nivel: 'Fácil',
        pergunta: 'Qual célula sanguínea é responsável pelo transporte de oxigênio?',
        opcoes: ['Leucócito', 'Plaqueta', 'Hemácia', 'Monócito'],
        resposta_correta: 2,
        explicacao: 'As hemácias (eritrócitos) contêm hemoglobina, proteína responsável pelo transporte de oxigênio dos pulmões para os tecidos.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual é a principal função das plaquetas?',
        opcoes: ['Defesa imunológica', 'Transporte de oxigênio', 'Hemostasia e coagulação', 'Produção de anticorpos'],
        resposta_correta: 2,
        explicacao: 'As plaquetas são essenciais para a hemostasia, formando o tampão plaquetário e participando da cascata de coagulação.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Onde ocorre a hematopoiese na vida adulta?',
        opcoes: ['Fígado', 'Baço', 'Medula Óssea', 'Gânglios linfáticos'],
        resposta_correta: 2,
        explicacao: 'Na vida adulta, a medula óssea é o principal local de produção das células sanguíneas.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual leucócito é o mais abundante no sangue periférico?',
        opcoes: ['Linfócito', 'Neutrófilo', 'Eosinófilo', 'Basófilo'],
        resposta_correta: 1,
        explicacao: 'Os neutrófilos representam 50-70% dos leucócitos circulantes, sendo os mais abundantes.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual célula precursora da série eritroide é a primeira identificável?',
        opcoes: ['Eritroblasto Basofílico', 'Proeritroblasto', 'Reticulócito', 'Eritroblasto Ortocromático'],
        resposta_correta: 1,
        explicacao: 'O proeritroblasto é a primeira célula morfologicamente identificável da série eritroide.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'O que significa "desvio à esquerda" no hemograma?',
        opcoes: ['Aumento de linfócitos', 'Aumento de neutrófilos bastonetes', 'Diminuição de plaquetas', 'Aumento de eosinófilos'],
        resposta_correta: 1,
        explicacao: 'Desvio à esquerda indica aumento de neutrófilos bastonetes (imaturos), sugerindo infecção aguda ou inflamação.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual célula sanguínea é anucleada e tem formato de disco bicôncavo?',
        opcoes: ['Plaqueta', 'Linfócito', 'Hemácia', 'Monócito'],
        resposta_correta: 2,
        explicacao: 'A hemácia madura é anucleada e possui formato bicôncavo para facilitar as trocas gasosas.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual leucócito está envolvido em reações alérgicas e combate a parasitas?',
        opcoes: ['Neutrófilo', 'Basófilo', 'Eosinófilo', 'Monócito'],
        resposta_correta: 2,
        explicacao: 'O eosinófilo possui grânulos com proteínas que combatem parasitas e modulam reações alérgicas.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'O que são reticulócitos?',
        opcoes: ['Hemácias velhas', 'Hemácias jovens anucleadas com restos de RNA', 'Plaquetas imaturas', 'Leucócitos imaturos'],
        resposta_correta: 1,
        explicacao: 'Reticulócitos são hemácias jovens, anucleadas, que ainda contêm restos de RNA ribossômico no citoplasma.'
    },
    {
        nivel: 'Fácil',
        pergunta: 'Qual é o principal local de produção de plaquetas?',
        opcoes: ['Fígado', 'Baço', 'Megacariócito na medula óssea', 'Gânglios linfáticos'],
        resposta_correta: 2,
        explicacao: 'As plaquetas são fragmentos citoplasmáticos dos megacariócitos na medula óssea.'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual característica morfológica define um promielócito?',
        opcoes: ['Núcleo segmentado', 'Presença de grânulos azurófilos (primários)', 'Citoplasma acidofílico', 'Núcleo em ferradura'],
        resposta_correta: 1,
        explicacao: 'O promielócito é caracterizado pela presença de grânulos primários (azurófilos) no citoplasma.'
    },
    {
        nivel: 'Médio',
        pergunta: 'O que é anisocitose?',
        opcoes: ['Variação na forma das hemácias', 'Variação no tamanho das hemácias', 'Diminuição da hemoglobina', 'Aumento do número de hemácias'],
        resposta_correta: 1,
        explicacao: 'Anisocitose é a presença de hemácias com tamanhos diferentes no mesmo esfregaço sanguíneo.'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual é a diferença entre um mieloblasto e um promielócito?',
        opcoes: ['O mieloblasto é maior', 'O promielócito tem grânulos, o mieloblasto não', 'O mieloblasto tem núcleo segmentado', 'Não há diferença'],
        resposta_correta: 1,
        explicacao: 'O mieloblasto não possui grânulos citoplasmáticos, enquanto o promielócito já apresenta grânulos primários (azurófilos).'
    },
    {
        nivel: 'Médio',
        pergunta: 'O que indica a presença de policromasia no sangue periférico?',
        opcoes: ['Anemia hemolítica', 'Aumento da atividade medular com liberação de reticulócitos', 'Deficiência de ferro', 'Infecção viral'],
        resposta_correta: 1,
        explicacao: 'Policromasia indica presença de reticulócitos (células jovens), refletindo aumento da atividade eritropoiética da medula.'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual alteração morfológica é característica da anemia falciforme?',
        opcoes: ['Esferócitos', 'Drepanócitos (hemácias falciformes)', 'Macrocitose', 'Hipocromia'],
        resposta_correta: 1,
        explicacao: 'Os drepanócitos ou hemácias falciformes são patognomônicos da anemia falciforme (HbS).'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual célula da série granulocítica apresenta núcleo em forma de rim ou ferradura?',
        opcoes: ['Mieloblasto', 'Promielócito', 'Mielócito', 'Metamielócito'],
        resposta_correta: 3,
        explicacao: 'O metamielócito é caracterizado pelo núcleo em formato de rim ou ferradura, com cromatina condensada.'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual a função dos linfócitos B?',
        opcoes: ['Fagocitose', 'Produção de anticorpos (imunidade humoral)', 'Liberação de histamina', 'Combate a parasitas'],
        resposta_correta: 1,
        explicacao: 'Linfócitos B são responsáveis pela produção de anticorpos, atuando na imunidade humoral.'
    },
    {
        nivel: 'Médio',
        pergunta: 'O que caracteriza um eritroblasto ortocromático?',
        opcoes: ['Citoplasma basofílico', 'Núcleo picnótico prestes a ser expulso', 'Múltiplos nucléolos', 'Citoplasma com policromasia'],
        resposta_correta: 1,
        explicacao: 'O eritroblasto ortocromático apresenta núcleo picnótico (altamente condensado) e citoplasma acidofílico pela hemoglobina.'
    },
    {
        nivel: 'Médio',
        pergunta: 'Qual leucócito se diferencia em macrófago nos tecidos?',
        opcoes: ['Neutrófilo', 'Eosinófilo', 'Linfócito', 'Monócito'],
        resposta_correta: 3,
        explicacao: 'O monócito circulante migra para os tecidos e se diferencia em macrófago, especializado em fagocitose.'
    },
    {
        nivel: 'Médio',
        pergunta: 'O que é poiquilocitose?',
        opcoes: ['Variação no tamanho das hemácias', 'Variação na forma das hemácias', 'Aumento do número de hemácias', 'Diminuição da hemoglobina'],
        resposta_correta: 1,
        explicacao: 'Poiquilocitose é a presença de hemácias com formas anormais e variadas no esfregaço sanguíneo.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual é a principal característica do megacariócito que permite a produção de plaquetas?',
        opcoes: ['Núcleo bilobulado', 'Citoplasma basofílico', 'Núcleo poliploide multilobulado e citoplasma fragmentado', 'Presença de grânulos azurófilos'],
        resposta_correta: 2,
        explicacao: 'O megacariócito maduro tem núcleo multilobulado e poliploide, e seu citoplasma se fragmenta para liberar plaquetas.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual alteração morfológica é caracterizada por hemácias esféricas sem palidez central?',
        opcoes: ['Drepanócitos', 'Esferócitos', 'Codócitos', 'Estomatócitos'],
        resposta_correta: 1,
        explicacao: 'Esferócitos são hemácias esféricas com perda da forma bicôncava, sem palidez central, comuns em anemias hemolíticas.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual a sequência correta da maturação da série granulocítica?',
        opcoes: [
            'Mieloblasto → Metamielócito → Promielócito → Mielócito → Bastonete → Segmentado',
            'Mieloblasto → Promielócito → Mielócito → Metamielócito → Bastonete → Segmentado',
            'Promielócito → Mieloblasto → Mielócito → Metamielócito → Segmentado → Bastonete',
            'Mieloblasto → Promielócito → Metamielócito → Mielócito → Bastonete → Segmentado'
        ],
        resposta_correta: 1,
        explicacao: 'A sequência correta é: Mieloblasto → Promielócito → Mielócito → Metamielócito → Bastonete → Segmentado.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'O que caracteriza o mielócito em relação ao metamielócito?',
        opcoes: ['Núcleo em bastão', 'Núcleo mais condensado e excêntrico', 'Presença de nucléolos', 'Capacidade mitótica preservada'],
        resposta_correta: 3,
        explicacao: 'O mielócito ainda pode sofrer mitose, enquanto o metamielócito já perdeu essa capacidade.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual a diferença fundamental entre linfócitos T e B quanto à atuação imunológica?',
        opcoes: ['T produzem anticorpos, B fazem fagocitose', 'T atuam na imunidade celular, B na humoral', 'T combatem parasitas, B combatem vírus', 'T são fagócitos, B não'],
        resposta_correta: 1,
        explicacao: 'Linfócitos T atuam na imunidade celular (destroem células infectadas); linfócitos B produzem anticorpos (imunidade humoral).'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual tipo de célula sanguínea possui grânulos que contêm histamina e heparina?',
        opcoes: ['Neutrófilo', 'Eosinófilo', 'Basófilo', 'Monócito'],
        resposta_correta: 2,
        explicacao: 'Os basófilos possuem grânulos ricos em histamina e heparina, liberados em reações alérgicas e inflamatórias.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'O que é endomitose e em qual célula ocorre?',
        opcoes: ['Divisão celular sem citocinese no megacariócito', 'Fragmentação do citoplasma do eritroblasto', 'Mitose do linfoblasto', 'Apoptose do neutrófilo'],
        resposta_correta: 0,
        explicacao: 'Endomitose é a replicação do DNA sem divisão celular, ocorrendo nos megacariócitos, tornando-os poliploides.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual a principal característica que diferencia um proeritroblasto de um eritroblasto basofílico?',
        opcoes: ['Tamanho do núcleo', 'Presença de nucléolos no proeritroblasto', 'Coloração do citoplasma', 'Formato da célula'],
        resposta_correta: 1,
        explicacao: 'O proeritroblasto possui nucléolos evidentes, enquanto o eritroblasto basofílico não apresenta nucléolos visíveis.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual alteração morfológica está associada à deficiência de vitamina B12 ou ácido fólico?',
        opcoes: ['Microcitose', 'Hipocromia', 'Macrocitose', 'Drepanócitos'],
        resposta_correta: 2,
        explicacao: 'Deficiência de B12 ou folato causa anemia megaloblástica com macrocitose (hemácias grandes) por alteração na síntese de DNA.'
    },
    {
        nivel: 'Difícil',
        pergunta: 'Qual é o marcador morfológico característico do promielócito na Leucemia Promielocítica Aguda (LMA M3)?',
        opcoes: ['Grânulos azurófilos em excesso', 'Núcleo bilobulado', 'Citoplasma vacuolizado', 'Núcleo em ferradura'],
        resposta_correta: 0,
        explicacao: 'Na LPA (LMA M3), os promielócitos apresentam grânulos azurófilos em abundância, às vezes com bastões de Auer.'
    }
];

// ==============================================
// FUNÇÃO PARA EMBARALHAR ARRAY (Fisher-Yates)
// ==============================================
function shuffleArray(arr) {
    for (let i = arr.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [arr[i], arr[j]] = [arr[j], arr[i]];
    }
    return arr;
}

// ==============================================
// FUNÇÃO PARA EMBARALHAR AS OPÇÕES DE UMA QUESTÃO
// ==============================================
function shuffleQuestionOptions(question) {
    const opcoes = question.opcoes.map((texto, idx) => ({
        texto: texto,
        originalIndex: idx
    }));
    const shuffled = shuffleArray([...opcoes]);
    const novaOrdem = shuffled.map(item => item.texto);
    const novoIndiceCorreto = shuffled.findIndex(item => item.originalIndex === question.resposta_correta);
    return {
        ...question,
        opcoes: novaOrdem,
        resposta_correta: novoIndiceCorreto
    };
}

// ==============================================
// FUNÇÃO PARA GERAR O QUIZ EMBARALHADO
// ==============================================
function gerarQuizEmbaralhado() {
    // 1. Embaralha a ordem das questões
    const questoesEmbaralhadas = shuffleArray([...quizQuestionsBase]);
    
    // 2. Para cada questão, embaralha a ordem das opções
    const questoesComOpcoesEmbaralhadas = questoesEmbaralhadas.map(q => shuffleQuestionOptions(q));
    
    return questoesComOpcoesEmbaralhadas;
}

// ==============================================
// ESTADO DO QUIZ
// ==============================================
let quizQuestions = [];
let quizEstado = {
    respostas: [],
    corrigidas: [],
    acertos: 0,
    erros: 0
};

// ==============================================
// FUNÇÕES DO QUIZ
// ==============================================
function renderizarQuiz() {
    const container = document.getElementById('quizContainer');
    container.innerHTML = '';

    document.getElementById('acertosCont').textContent = quizEstado.acertos;
    document.getElementById('errosCont').textContent = quizEstado.erros;
    const totalResp = quizEstado.corrigidas.filter(v => v === true).length;
    document.getElementById('totalRespondidas').textContent = totalResp;

    quizQuestions.forEach((q, idx) => {
        const card = document.createElement('div');
        card.className = 'quiz-card';
        card.id = 'quiz-card-' + idx;

        let opcoesHTML = '';
        q.opcoes.forEach((opcao, opIdx) => {
            const letra = String.fromCharCode(65 + opIdx);
            let classe = 'quiz-opcao';
            if (quizEstado.corrigidas[idx]) {
                if (opIdx === q.resposta_correta) {
                    classe += ' correta';
                } else if (opIdx === quizEstado.respostas[idx] && opIdx !== q.resposta_correta) {
                    classe += ' incorreta';
                }
            }
            if (quizEstado.respostas[idx] === opIdx && !quizEstado.corrigidas[idx]) {
                classe += ' selected';
            }
            opcoesHTML += `
                <div class="${classe}" data-question="${idx}" data-value="${opIdx}" onclick="selecionarOpcaoQuiz(${idx}, ${opIdx})">
                    ${letra}) ${opcao}
                </div>
            `;
        });

        let feedbackHTML = '';
        if (quizEstado.corrigidas[idx]) {
            const acertou = (quizEstado.respostas[idx] === q.resposta_correta);
            feedbackHTML = `
                <div class="quiz-feedback-inline ${acertou ? 'correta' : 'incorreta'}">
                    <strong>${acertou ? '✅ Correta!' : '❌ Incorreta!'}</strong> ${q.explicacao}
                </div>
            `;
        }

        const btnDisabled = quizEstado.corrigidas[idx] ? 'disabled' : '';

        card.innerHTML = `
            <span class="quiz-nivel nivel-${q.nivel}">${q.nivel}</span>
            <div class="quiz-pergunta">${idx+1}. ${q.pergunta}</div>
            ${opcoesHTML}
            ${feedbackHTML}
            <div class="quiz-actions">
                <button class="quiz-submit-btn" id="submitBtn-${idx}" ${btnDisabled} onclick="responderQuiz(${idx})">
                    ${quizEstado.corrigidas[idx] ? '✅ Respondida' : '📝 Responder'}
                </button>
            </div>
        `;
        container.appendChild(card);
    });
}

function selecionarOpcaoQuiz(qIdx, val) {
    if (quizEstado.corrigidas[qIdx]) return;

    const card = document.getElementById('quiz-card-' + qIdx);
    const opcoes = card.querySelectorAll('.quiz-opcao');
    opcoes.forEach(o => o.classList.remove('selected'));
    opcoes.forEach(o => {
        if (parseInt(o.getAttribute('data-value')) === val) {
            o.classList.add('selected');
        }
    });
    quizEstado.respostas[qIdx] = val;
}

function responderQuiz(qIdx) {
    if (quizEstado.corrigidas[qIdx]) return;

    const resposta = quizEstado.respostas[qIdx];
    if (resposta === null || resposta === undefined) {
        alert('Selecione uma opção antes de responder!');
        return;
    }

    const questao = quizQuestions[qIdx];
    const acertou = (resposta === questao.resposta_correta);

    quizEstado.corrigidas[qIdx] = true;
    if (acertou) {
        quizEstado.acertos++;
    } else {
        quizEstado.erros++;
    }

    renderizarQuiz();

    const card = document.getElementById('quiz-card-' + qIdx);
    if (card) {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
}

function reiniciarQuiz() {
    // Gerar novo conjunto de questões embaralhadas
    quizQuestions = gerarQuizEmbaralhado();
    
    quizEstado = {
        respostas: new Array(quizQuestions.length).fill(null),
        corrigidas: new Array(quizQuestions.length).fill(false),
        acertos: 0,
        erros: 0
    };
    renderizarQuiz();
    document.getElementById('quizContainer').scrollIntoView({ behavior: 'smooth' });
}

// ==============================================
// FUNÇÕES DE VÍDEO - YOUTUBE E LOCAL
// ==============================================
function abrirVideo(videoId, videoTipo) {
    if (!videoId) {
        alert('Vídeo não disponível para este conteúdo.');
        return;
    }

    const wrapper = document.getElementById('videoWrapper');
    
    if (videoTipo === 'local' || (typeof videoId === 'string' && videoId.endsWith('.mp4'))) {
        wrapper.innerHTML = `
            <video controls autoplay style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: #000;">
                <source src="${videoId}" type="video/mp4">
                Seu navegador não suporta vídeos HTML5.
            </video>
        `;
    } else {
        wrapper.innerHTML = `
            <iframe style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                    frameborder="0" 
                    allowfullscreen 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    src="https://www.youtube.com/embed/${videoId}?autoplay=1&rel=0">
            </iframe>
        `;
    }
    
    document.getElementById('videoModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}

function fecharVideoModal() {
    document.getElementById('videoModal').classList.remove('active');
    document.getElementById('videoWrapper').innerHTML = '';
    document.body.style.overflow = 'auto';
}

// ==============================================
// DEMAIS FUNÇÕES (ATLAS, BUSCA, MODAIS)
// ==============================================

function renderizarCards() {
    const grid = document.getElementById('cardsGrid');
    grid.innerHTML = '';
    cards.forEach((card, index) => {
        const div = document.createElement('div');
        div.className = 'card';
        if (card.is_referencia) {
            div.classList.add('card-referencia');
        }
        div.setAttribute('data-card-index', index);
        
        const videoBtn = card.is_referencia ? '' : `<button class="card-btn" onclick="abrirModal(${index})">📖 Ler mais + Vídeo</button>`;
        const videoImg = card.is_referencia ? '' : `<img src="${card.imagem}" alt="${card.titulo}" class="card-img" onclick="abrirModal(${index})" />`;
        
        div.innerHTML = `
            <div style="position: relative;">
                ${videoImg}
                <span class="card-badge">${card.numero}</span>
            </div>
            <div class="card-content">
                <span class="card-categoria">${card.categoria}</span>
                <h3 class="card-titulo">${card.titulo}</h3>
                <div class="card-texto">${card.conteudo.replace(/\n/g, '<br>')}</div>
                ${videoBtn}
            </div>
        `;
        grid.appendChild(div);
    });
}

function popularCategorias() {
    const select = document.getElementById('categoriaFiltro');
    const categorias = [];
    cards.forEach(c => { if (!categorias.includes(c.categoria)) categorias.push(c.categoria); });
    categorias.sort();
    categorias.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat;
        opt.textContent = cat;
        select.appendChild(opt);
    });
}

function abrirModal(index) {
    const card = cards[index];
    if (!card) return;
    document.getElementById('modalTitulo').innerHTML = card.numero + ' - ' + card.titulo;
    document.getElementById('modalImg').src = card.imagem;
    document.getElementById('modalConteudo').innerHTML = card.conteudo.replace(/\n/g, '<br>');
    document.getElementById('modal').classList.add('active');
    document.body.style.overflow = 'hidden';
    window.currentCardIndex = index;
}

function fecharModal() {
    document.getElementById('modal').classList.remove('active');
    document.body.style.overflow = 'auto';
}

function initTabs() {
    const tabs = document.querySelectorAll('.tab-btn');
    const contents = document.querySelectorAll('.tab-content');
    tabs.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabId = this.getAttribute('data-tab');
            tabs.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            contents.forEach(c => c.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        });
    });
}

function initModals() {
    document.getElementById('modalVideoBtn').addEventListener('click', function() {
        const idx = window.currentCardIndex;
        if (idx !== null && idx !== undefined) {
            const card = cards[idx];
            abrirVideo(card.video_id, card.video_tipo);
        }
    });
    
    document.getElementById('modal').addEventListener('click', function(e) {
        if (e.target === this) fecharModal();
    });
    
    document.getElementById('videoModal').addEventListener('click', function(e) {
        if (e.target === this) fecharVideoModal();
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (document.getElementById('modal').classList.contains('active')) fecharModal();
            if (document.getElementById('videoModal').classList.contains('active')) fecharVideoModal();
        }
    });
}

function buscarCardsInteligente(termo, categoriaFiltro) {
    termo = termo.toLowerCase().trim();
    const resultados = [];
    const palavras = termo.split(' ').filter(p => p.length > 0);
    for (let i = 0; i < cards.length; i++) {
        const card = cards[i];
        let relevancia = 0;
        const termosEncontrados = [];
        const textoCompleto = (card.titulo + ' ' + card.conteudo + ' ' + card.palavras_chave).toLowerCase();
        for (let j = 0; j < palavras.length; j++) {
            const palavra = palavras[j];
            if (palavra.length < 3) continue;
            if (textoCompleto.indexOf(palavra) !== -1) {
                relevancia += 2;
                termosEncontrados.push(palavra);
            }
            if (card.titulo.toLowerCase().indexOf(palavra) !== -1) relevancia += 2;
            if (card.palavras_chave.toLowerCase().indexOf(palavra) !== -1) relevancia += 3;
        }
        if (categoriaFiltro && categoriaFiltro !== card.categoria) continue;
        const caracteristicas = {
            'anucleada': ['hemácia', 'reticulócito', 'plaqueta'],
            'núcleo em ferradura': ['metamielócito', 'bastonete'],
            'núcleo em rim': ['metamielócito', 'monócito', 'promonócito'],
            'grânulos acidofílicos': ['eosinófilo'],
            'grânulos basofílicos': ['basófilo'],
            'fagocitose': ['neutrófilo', 'monócito'],
            'transporte de oxigênio': ['hemácia', 'eritrócito'],
            'hemostasia': ['plaqueta'],
            'anticorpos': ['linfócito'],
            'célula gigante': ['megacariócito'],
            'poliploide': ['megacariócito'],
            'nucleolo evidente': ['proeritroblasto', 'mieloblasto', 'monoblasto', 'linfoblasto', 'megacarioblasto'],
            'cromatina frouxa': ['proeritroblasto', 'mieloblasto', 'monoblasto', 'linfoblasto'],
            'cromatina condensada': ['eritroblasto basofílico', 'eritroblasto ortocromático', 'metamielócito'],
            'basofílico': ['proeritroblasto', 'eritroblasto basofílico', 'mieloblasto', 'monoblasto', 'linfoblasto'],
            'acidofílico': ['eritroblasto ortocromático', 'eosinófilo', 'hemácia'],
            'policromasia': ['eritroblasto policromático', 'reticulócito'],
            'desvio à esquerda': ['bastonete'],
            'anemia falciforme': ['drepanócitos'],
            'hemólise': ['esferócitos', 'policromasia'],
            'vitamina B12': ['macrocitose', 'anisocitose'],
            'ácido fólico': ['macrocitose', 'anisocitose'],
            'ferro': ['microcitose', 'hipocromia', 'anisocitose']
        };
        for (const key in caracteristicas) {
            if (termo.indexOf(key) !== -1) {
                const alvos = caracteristicas[key];
                for (let k = 0; k < alvos.length; k++) {
                    if (card.titulo.toLowerCase().indexOf(alvos[k]) !== -1 || 
                        card.palavras_chave.toLowerCase().indexOf(alvos[k]) !== -1) {
                        relevancia += 5;
                        termosEncontrados.push(key);
                    }
                }
            }
        }
        if (relevancia > 0) {
            resultados.push({
                card: card,
                indice: i,
                relevancia: relevancia,
                termos: termosEncontrados.filter((item, pos, self) => self.indexOf(item) === pos)
            });
        }
    }
    resultados.sort((a, b) => b.relevancia - a.relevancia);
    return resultados;
}

function destacarTermo(texto, termo) {
    const palavras = termo.toLowerCase().trim().split(' ').filter(p => p.length > 0);
    let textoDestacado = texto;
    for (let i = 0; i < palavras.length; i++) {
        const palavra = palavras[i];
        if (palavra.length < 3) continue;
        const regex = new RegExp('(' + palavra.replace(/[.*+?^${}()|[\]\\]/g, '\\$&') + ')', 'gi');
        textoDestacado = textoDestacado.replace(regex, '<span class="destaque">$1</span>');
    }
    return textoDestacado;
}

function realizarBusca() {
    const termo = document.getElementById('termoBusca').value;
    const categoria = document.getElementById('categoriaFiltro').value;
    if (!termo.trim()) {
        document.getElementById('resultadosBusca').innerHTML = `
            <div style="background: #fff3cd; border-radius: 12px; padding: 1rem; border-left: 4px solid #ffc107;">
                <p style="color:#856404;">Por favor, digite um termo para pesquisar.</p>
            </div>
        `;
        return;
    }
    const resultados = buscarCardsInteligente(termo, categoria);
    let html = `<div style="background: white; border-radius: 20px; padding: 1.5rem;">
        <h3>📋 Resultados da busca por: "${termo}"</h3>
        <p>Encontrados ${resultados.length} resultado(s)</p>`;
    if (resultados.length > 0) {
        for (let i = 0; i < resultados.length; i++) {
            const res = resultados[i];
            const conteudoDestacado = destacarTermo(res.card.conteudo, termo);
            html += `
                <div class="resultado-item" onclick="abrirModal(${res.indice})">
                    <strong>${res.card.numero} - ${res.card.titulo}</strong>
                    <span style="background:#e9edf2; padding:2px 8px; border-radius:12px; font-size:0.7rem;">${res.card.categoria}</span>
                    <div style="font-size:0.85rem; margin-top:0.5rem;">${conteudoDestacado.substring(0, 200)}...</div>
                    <div class="resultado-termos">🔍 Termos encontrados: ${res.termos.map(t => `<span>${t}</span>`).join(' ')}</div>
                    <div style="margin-top: 0.5rem; font-size:0.8rem; color:#1a2a6c;">⭐ Relevância: ${'⭐'.repeat(Math.min(5, Math.ceil(res.relevancia / 3)))}</div>
                </div>
            `;
        }
    } else {
        html += `
            <div class="sem-resultados">
                <p>Nenhum resultado encontrado. Tente:</p>
                <ul>
                    <li>Palavras-chave: eritrócito, neutrófilo, plaqueta, linfócito</li>
                    <li>Características: anucleada, núcleo em ferradura, grânulos acidofílicos</li>
                    <li>Funções: transporte de oxigênio, fagocitose, hemostasia</li>
                    <li>Alterações: anemia falciforme, macrocitose, hipocromia</li>
                </ul>
            </div>
        `;
    }
    html += '</div>';
    document.getElementById('resultadosBusca').innerHTML = html;
}

function limparBusca() {
    document.getElementById('termoBusca').value = '';
    document.getElementById('categoriaFiltro').value = '';
    document.getElementById('resultadosBusca').innerHTML = `
        <div class="guia-estudos">
            <h3>📌 Como usar a Central de Estudos</h3>
            <p>Digite qualquer termo relacionado à hematologia no campo de busca. O sistema busca em:</p>
            <ul><li><strong>Títulos</strong> dos cards</li><li><strong>Conteúdo</strong> completo de cada card</li><li><strong>Palavras-chave</strong> específicas de cada célula</li><li><strong>Características</strong> morfológicas (ex: "anucleada", "núcleo em ferradura")</li><li><strong>Funções</strong> (ex: "transporte de oxigênio", "fagocitose")</li></ul>
            <p><strong>Exemplos de busca:</strong></p>
            <ul><li><strong>Por célula:</strong> "eritrócito", "neutrófilo", "linfócito"</li><li><strong>Por característica:</strong> "anucleada", "núcleo em ferradura", "grânulos acidofílicos"</li><li><strong>Por função:</strong> "transporte de oxigênio", "hemostasia", "fagocitose"</li><li><strong>Por alteração:</strong> "anemia falciforme", "macrocitose", "hipocromia"</li></ul>
            <p style="margin-top:0.5rem;"><strong>Clique em qualquer resultado</strong> para abrir o card completo com vídeo.</p>
        </div>
    `;
}

function initSearchEnter() {
    document.getElementById('termoBusca').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') realizarBusca();
    });
}

function init() {
    // Inicializa o quiz com questões embaralhadas
    quizQuestions = gerarQuizEmbaralhado();
    quizEstado = {
        respostas: new Array(quizQuestions.length).fill(null),
        corrigidas: new Array(quizQuestions.length).fill(false),
        acertos: 0,
        erros: 0
    };
    
    renderizarCards();
    renderizarQuiz();
    popularCategorias();
    initTabs();
    initModals();
    initSearchEnter();
    limparBusca();
}

document.addEventListener('DOMContentLoaded', init);
</script>

</body>
</html>