import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import api from "../services/api";

export default function AdminRequestDetail() {
  const { id } = useParams();
  const [request, setRequest] = useState(null);
  const [loading, setLoading] = useState(true);
  const navigate = useNavigate();

  useEffect(() => {
    const token = localStorage.getItem("token");

    api.get(`/admin/requests/${id}`, {
      headers: { Authorization: `Bearer ${token}` },
    })
      .then((res) => {
        setRequest(res.data.data);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Error al cargar solicitud:", err);
        alert("No se pudo cargar la solicitud.");
        navigate("/admin/dashboard");
      });
  }, [id]);

  const handleAction = async (status) => {
    const token = localStorage.getItem("token");

    try {
      await api.put(`/admin/requests/${id}/status`, { status }, {
        headers: { Authorization: `Bearer ${token}` },
      });
      alert(`Solicitud actualizada a: ${status}`);
      navigate("/admin/dashboard");
    } catch (err) {
      console.error("Error al cambiar estado:", err);
      alert("No se pudo actualizar el estado.");
    }
  };

  if (loading || !request) return <p>Cargando...</p>;

  return (
    <div>
      <h2>Detalle de Solicitud #{request.id}</h2>
      <p><strong>Nombre completo:</strong> {request.full_name}</p>
      <p><strong>Tipo:</strong> {request.certificate_type}</p>
      <p><strong>Documento N°:</strong> {request.document_number}</p>
      <p><strong>Estado actual:</strong> {request.status}</p>
      <p><strong>Usuario:</strong> {request.user?.name} ({request.user?.email})</p>

      <p>
        <strong>Documento:</strong>{" "}
        <a
          href={`http://localhost:8000/storage/${request.document_path}`}
          target="_blank"
          rel="noreferrer"
        >
          Descargar documento
        </a>
      </p>

      <div style={{ marginTop: "20px" }}>
        <button onClick={() => handleAction("Aprobado")}>✅ Aprobar</button>{" "}
        <button onClick={() => handleAction("Rechazado")}>❌ Rechazar</button>{" "}
        <button onClick={() => handleAction("Corrección Solicitada")}>
          ✏️ Pedir Corrección
        </button>
      </div>
    </div>
  );
}
