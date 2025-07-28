// src/pages/Dashboard.jsx
import { useNavigate } from "react-router-dom";

export default function Dashboard() {
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem("token");
    navigate("/login");
  };

  return (
    <div style={{ padding: "2rem" }}>
      <h2>Bienvenido al sistema de certificados</h2>

      <div style={{ display: "flex", flexDirection: "column", gap: "1rem", marginTop: "2rem" }}>
        <button onClick={() => navigate("/solicitar")}>📄 Solicitar Certificado</button>
        <button onClick={() => navigate("/solicitudes")}>📋 Ver Mis Solicitudes</button>
        <button onClick={() => navigate("/certificados")}>📥 Ver/Descargar Certificados</button>
        <button onClick={handleLogout}>🚪 Cerrar Sesión</button>
      </div>
    </div>
  );
}
