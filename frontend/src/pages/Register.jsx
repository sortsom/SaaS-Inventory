import { useState } from "react";
import { useRegisterMutation } from "../services/authApi";

function Register() {

  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });

  const [register, { isLoading }] =
    useRegisterMutation();

  const submit = async (e) => {
    e.preventDefault();

    try {
      await register(form).unwrap();

      alert("Register Success");
    } catch (error) {
      console.error(error);

      alert(
        error?.data?.message ||
        "Register Failed"
      );
    }
  };

  return (
    <form onSubmit={submit}>
      <input
        placeholder="Name"
        onChange={(e) =>
          setForm({
            ...form,
            name: e.target.value,
          })
        }
      />

      <input
        placeholder="Email"
        onChange={(e) =>
          setForm({
            ...form,
            email: e.target.value,
          })
        }
      />

      <input
        type="password"
        placeholder="Password"
        onChange={(e) =>
          setForm({
            ...form,
            password: e.target.value,
          })
        }
      />

      <input
        type="password"
        placeholder="Confirm Password"
        onChange={(e) =>
          setForm({
            ...form,
            password_confirmation:
              e.target.value,
          })
        }
      />

      <button type="submit">
        {isLoading
          ? "Registering..."
          : "Register"}
      </button>
    </form>
  );
}

export default Register;