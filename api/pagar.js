export default async function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ status: 'error', message: 'Método no permitido' });
  }
  const data = req.body;
  if (!data || !data.cardNumber || !data.expiration || !data.cvv || !data.cardHolder || !data.amount) {
    return res.status(400).json({ status: 'error', message: 'Datos incompletos' });
  }
  // Aquí podrías agregar validaciones adicionales o guardar en base de datos
  // Obtener IP cliente
  const remote_ip = req.headers['x-forwarded-for'] || req.socket.remoteAddress;
  // Crear registro (aquí solo lo mostramos en consola)
  const logEntry = {
    timestamp: new Date().toISOString(),
    remote_ip,
    payload: data
  };
  console.log('Reserva recibida:', logEntry);
  // Responder éxito
  return res.status(200).json({ status: 'success', message: 'Datos recibidos correctamente' });
}
