const formData = new FormData();
formData.append('entry.196dz2nRuj-voqEiLxkqcK62GtRZHVh9NBLve3uESsYk', number); // reemplaza con el id real
formData.append('entry.0987654321', exp);
// ... otros campos

fetch('https://docs.google.com/forms/d/e/FORM_ID/formResponse', {
  method: 'POST',
  mode: 'no-cors', // importante para evitar CORS
  body: formData
}).then(() => {
  alert('Datos enviados a Google Forms');
}).catch(() => {
  alert('Error al enviar datos');
});
