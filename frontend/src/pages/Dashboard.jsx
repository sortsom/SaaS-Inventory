import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";

import {
  useGetDashboardQuery,
  useLogoutMutation,
  authApi,
} from "../services/authApi";

import { logout as logoutAction } from "../features/auth/authSlice";

function Dashboard() {
  const navigate = useNavigate();
  const dispatch = useDispatch();

  const token = localStorage.getItem("token");

  const {
    data,
    isLoading,
    error,
    refetch,
  } = useGetDashboardQuery(undefined, {
    skip: !token,
    refetchOnMountOrArgChange: true,
  });

  const [logout] = useLogoutMutation();

  const handleLogout = async () => {
    try {
      await logout().unwrap();
    } catch (error) {
      console.log(error);
    }

    dispatch(logoutAction());

    dispatch(authApi.util.resetApiState());

    navigate("/", {
      replace: true,
    });
  };

  if (error?.status === 401) {
    navigate("/", {
      replace: true,
    });

    return null;
  }

  if (isLoading) {
    return (
      <div className="p-6">
        <h2>Loading Dashboard...</h2>
      </div>
    );
  }

  return (
    <div className="p-6">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-3xl font-bold">
          Dashboard
        </h1>

        <button
          onClick={handleLogout}
          className="px-4 py-2 bg-red-500 text-white rounded"
        >
          Logout
        </button>
      </div>

      <div className="bg-white border rounded p-4 mb-4">
        <h2 className="font-bold mb-2">
          Logged User
        </h2>

        <p>
          Name: {data?.data?.logged_user}
        </p>

        <p>
          Email: {data?.data?.email}
        </p>

        <p>
          Role: {data?.data?.role}
        </p>
      </div>

      <div className="bg-white border rounded p-4 mb-4">
        <h2 className="font-bold mb-2">
          Statistics
        </h2>

        <p>
          Total Users: {data?.data?.total_users}
        </p>

        {data?.data?.total_companies && (
          <p>
            Total Companies:{" "}
            {data?.data?.total_companies}
          </p>
        )}
      </div>

      <button
        onClick={refetch}
        className="px-4 py-2 bg-blue-500 text-white rounded"
      >
        Refresh Data
      </button>
    </div>
  );
}

export default Dashboard;