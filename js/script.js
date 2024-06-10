// document.addEventListener('DOMContentLoaded', () => {
//     const ciudadInput = document.getElementById('ciudad');
//     const suggestionsDiv = document.querySelector('.sugerencia');

//     function normalizeString(str) {
//         return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
//     }

//     ciudadInput.addEventListener('input', () => {
//         const ciudad = normalizeString(ciudadInput.value.trim());
//         if (ciudad.length > 0) {
//             fetch('data/municipios.json')
//                 .then(response => response.json())
//                 .then(data => {
//                     const municipios = data.map(municipio => normalizeString(municipio.nm));
//                     const suggestions = municipios.filter(municipio => {
//                         const minLength = Math.min(ciudad.length, municipio.length);
//                         const matchLength = ciudad.split('').filter((char, index) => char === municipio[index]).length;
//                         const matchPercentage = matchLength / minLength;
//                         return matchPercentage >= 0.75;
//                     });

//                     // Limpiar sugerencias anteriores
//                     suggestionsDiv.innerHTML = '';

//                     if (suggestions.length > 0) {
//                         suggestionsDiv.innerHTML = `<p>Sugerencias: ${suggestions.slice(0, 5).join(', ')}</p>`;
//                     } else if (ciudad.length > 2) {
//                         suggestionsDiv.innerHTML = `<p>No se encontraron coincidencias suficientes para "${ciudadInput.value}".</p>`;
//                     }
//                 });
//         } else {
//             suggestionsDiv.innerHTML = '';
//         }
//     });
// });


document.addEventListener('DOMContentLoaded', () => {
    const ciudadInput = document.getElementById('ciudad');
    const suggestionsDiv = document.querySelector('.sugerencia');

    function normalizeString(str) {
        return str.normalize("NFD").replace(/[\u0300-\u036f]/g, "").toLowerCase();
    }

    ciudadInput.addEventListener('input', () => {
        const ciudad = normalizeString(ciudadInput.value.trim());
        if (ciudad.length > 0) {
            fetch('data/municipios.json')
                .then(response => response.json())
                .then(data => {
                    const suggestions = data.filter(municipio => {
                        const normalizedMunicipio = normalizeString(municipio.nm);
                        const minLength = Math.min(ciudad.length, normalizedMunicipio.length);
                        const matchLength = ciudad.split('').filter((char, index) => char === normalizedMunicipio[index]).length;
                        const matchPercentage = matchLength / minLength;
                        return matchPercentage >= 0.75;
                    });

                    // Limpiar sugerencias anteriores
                    suggestionsDiv.innerHTML = '';

                    if (suggestions.length > 0) {
                        suggestionsDiv.innerHTML = `<p>Sugerencias: ${suggestions.slice(0, 5).map(s => s.nm).join(', ')}</p>`;
                    } else if (ciudad.length > 2) {
                        suggestionsDiv.innerHTML = `<p>No se encontraron coincidencias suficientes para "${ciudadInput.value}".</p>`;
                    }
                });
        } else {
            suggestionsDiv.innerHTML = '';
        }
    });
});

