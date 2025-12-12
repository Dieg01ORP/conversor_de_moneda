<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Conversor de Monedas en Vivo</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
        background: linear-gradient(135deg, #0f172a, #1e293b);
        font-family: 'Inter', sans-serif;
    }

    .card {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(20px);
        border-radius: 18px;
        border: 1px solid rgba(255,255,255,0.15);
    }

    /* Select elegante */
    .select-custom {
        appearance: none;
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255,255,255,0.3);
        padding: 12px;
        border-radius: 12px;
        color: white;
        width: 100%;
        cursor: pointer;
        position: relative;
    }

    .select-wrapper {
        position: relative;
    }

    /* Flecha personalizada */
    .select-wrapper::after {
        content: "▾";
        font-size: 18px;
        color: #cbd5e1;
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        pointer-events: none;
    }

    select option {
        background: #1e293b;
        color: white;
        font-size: 16px;
        padding: 10px;
    }

</style>

</head>
<body class="flex items-center justify-center min-h-screen px-4">

<div class="card p-8 w-full max-w-lg shadow-2xl">

    <h2 class="text-3xl font-bold text-center text-white mb-8 flex items-center justify-center gap-2">
        <span>💱</span> Conversor de Monedas en Vivo
    </h2>

    <div class="space-y-5">

        <!-- Cantidad -->
        <input 
            id="amount"
            type="number"
            step="0.01"
            placeholder="Cantidad"
            class="w-full p-3 rounded-xl bg-white/15 text-white placeholder-gray-300 border border-white/20 focus:outline-none"
        >

        <!-- Seleccionar moneda origen -->
        <div>
            <label class="text-white font-semibold mb-1 block">De:</label>
            <div class="select-wrapper">
                <select id="from" class="select-custom"></select>
            </div>
        </div>

        <!-- Seleccionar moneda destino -->
        <div>
            <label class="text-white font-semibold mb-1 block">A:</label>
            <div class="select-wrapper">
                <select id="to" class="select-custom"></select>
            </div>
        </div>

        <!-- Botón -->
        <button 
            onclick="convertCurrency()"
            class="w-full bg-blue-500 hover:bg-blue-600 transition p-3 rounded-xl text-white text-lg font-semibold">
            Convertir
        </button>

        <!-- Resultado -->
        <div id="result" class="hidden mt-4 text-center text-xl font-semibold text-white p-4 rounded-xl bg-green-600/40 border border-green-400"></div>

    </div>

</div>

<script>
const API_URL = "https://open.er-api.com/v6/latest/USD";
let rates = {};
let currencyList = [];

// Cargar monedas
async function loadCurrencies() {
    try {
        const res = await fetch(API_URL);
        const data = await res.json();
        rates = data.rates;
        currencyList = Object.keys(rates);

        const fromSelect = document.getElementById("from");
        const toSelect = document.getElementById("to");

        currencyList.forEach(moneda => {
            fromSelect.innerHTML += `<option value="${moneda}">${moneda}</option>`;
            toSelect.innerHTML += `<option value="${moneda}">${moneda}</option>`;
        });

        fromSelect.value = "USD";
        toSelect.value = "PEN";

    } catch (error) {
        alert("Error al cargar las monedas.");
    }
}
loadCurrencies();

// Conversión
function convertCurrency() {
    const amount = parseFloat(document.getElementById("amount").value);
    const from = document.getElementById("from").value;
    const to = document.getElementById("to").value;

    if (!amount) {
        alert("Ingresa una cantidad válida.");
        return;
    }

    const usdValue = amount / rates[from];
    const finalValue = usdValue * rates[to];

    const resultDiv = document.getElementById("result");
    resultDiv.innerHTML = `Resultado: <strong>${finalValue.toFixed(2)} ${to}</strong>`;
    resultDiv.classList.remove("hidden");
}
</script>

</body>
</html>
