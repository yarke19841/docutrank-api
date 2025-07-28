import { Link, Outlet } from "react-router-dom";

export default function AdminLayout() {
  return (
    <div style={{ display: "flex", minHeight: "100vh" }}>
      <aside style={{ width: "220px", background: "#f5f5f5", padding: "20px" }}>
        <h3>Panel Admin</h3>
        <ul>
          <li><Link to="/admin/dashboard">📋 Ver Solicitudes</Link></li>
        </ul>
      </aside>
      <main style={{ flex: 1, padding: "20px" }}>
        <Outlet />
      </main>
    </div>
  );
}
