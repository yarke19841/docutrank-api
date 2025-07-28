import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import api from "../services/api";

export default function AdminDashboard() {
  const [requests, setRequests] = useState([]);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const fetchRequests = async () => {
      const token = localStorage.getItem("token");

      try {
        const res = await api.get("/admin/requests", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setRequests(res.data.data);
      } catch (err) {
        console.error("Error al cargar las solicitudes:", err);
        alert("Error al cargar las solicitudes.");
      } finally {
        setLoading(false);
      }
    };

    fetchRequests();
  }, []);

  const goToDetail = (id) => {
    navigate(`/admin/requests/${id}`);
  };

  return (
    <div style={{ padding: "20px" }}>
      <h2>Panel de Solicitudes</h2>

      {loading ? (
        <p>Cargando...</p>
      ) : requests.length === 0 ? (
        <p>No hay solicitudes registradas.</p>
      ) : (
        <table border="1" cellPadding="8" cellSpacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Solicitante</th>
              <th>Tipo</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            {requests.map((req) => (
              <tr key={req.id}>
                <td>{req.id}</td>
                <td>{req.user?.name || "Desconocido"}</td>
                <td>{req.certificate_type}</td>
                <td>{req.status}</td>
                <td>{new Date(req.created_at).toLocaleString()}</td>
                <td>
                  <button onClick={() => goToDetail(req.id)}>Ver detalle</button>
                </td>
              </tr>
            ))}
          </tbody>
        </table>
      )}
    </div>
  );
}
