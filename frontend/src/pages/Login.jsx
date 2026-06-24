import { useState } from "react";
import { Eye, EyeOff } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";

import { useLoginMutation } from "../services/authApi";
import { setCredentials } from "../features/auth/authSlice";
import loginIllustration from "../assets/images/login-illustration.png";
export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [showPassword, setShowPassword] = useState(false);
  const [keepSignedIn, setKeepSignedIn] = useState(false);

  const navigate = useNavigate();
  const dispatch = useDispatch();

  const [login, { isLoading }] = useLoginMutation();

  const handleLogin = async (e) => {
    e.preventDefault();

    try {
      const response = await login({
        email,
        password,
      }).unwrap();

      console.log("LOGIN RESPONSE:", response);

      dispatch(setCredentials(response));

      navigate("/dashboard", {
        replace: true,
      });
    } catch (error) {
      console.error(error);

      alert(
        error?.data?.message ||
          "Invalid email or password"
      );
    }
  };

  return (
    <div className="min-h-screen flex bg-white">
      {/* LEFT SIDE */}
      <div className="hidden lg:flex w-1/2 bg-[#ffffff] relative items-center justify-center">
        <div className="absolute top-10 left-10">
          <h1
  className="text-3xl font-bold text-[#0A6E8A]"
  style={{ fontFamily: "Noto Sans Khmer" }}
>
   សុរិយា ស្តុក គ្រប់គ្រងស្តុករបស់អ្នកយ៉ាងមានប្រសិទ្ធភាព
</h1>
        {/* list of stock quantity khmer features */}
        <ul className="mt-4 text-slate-600 list-disc list-inside" style={{ fontFamily: "Noto Sans Khmer" }}>
          <li>គ្រប់គ្រងផលិតផល និងស្តុកបានយ៉ាងងាយស្រួល</li>
          <li>តាមដានការលក់ និងការទិញបានពេញលេញ</li>
          <li>រាយការណ៍ និងវិភាគស្តុកជាក់លាក់</li>
          <li>ដំណើរការដោយរលូន និងប្រើប្រាស់ងាយស្រួល</li>
          <li>គាំទ្រក្រុមហ៊ុនតូច និងមធ្យម</li>
          <li>ជួយសន្សំសំចៃពេលវេលា និងធនធាន</li>
          <li>បង្កើនប្រសិទ្ធភាព និងផលិតភាព</li>
          <li>Live Chart and Auto Response Comments</li>
          <li>facebook Integration</li>
        </ul>

        </div>

        <img
  src={loginIllustration}
  alt="Login Illustration"
  className="w-[80%] max-w-2xl object-contain"
/>
      </div>

      {/* RIGHT SIDE */}
      <div className="w-full lg:w-1/2 flex items-center justify-center">
        <div className="w-full max-w-lg px-8">
          <h1 className="text-4xl font-bold text-slate-800"​ style={{ fontFamily: "Noto Sans Khmer" }}>
            សូមស្វាគមន៍
          </h1>

          <p className="mt-3 text-slate-500" style={{ fontFamily: "Noto Sans Khmer" }}>
            ចូលប្រើដើម្បីចូលទៅកាន់ផ្ទាំងគ្រប់គ្រងស្តុករបស់អ្នក។
          </p>

          <form
            onSubmit={handleLogin}
            className="mt-10 space-y-6"
          >
            {/* EMAIL */}
            <div>
              <label className="block mb-2 text-sm font-medium text-slate-700">
                Email Address
              </label>

              <input
                type="email"
                value={email}
                onChange={(e) =>
                  setEmail(e.target.value)
                }
                placeholder="admin@example.com"
                required
                className="w-full h-12 px-4 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0A6E8A] focus:border-transparent"
              />
            </div>

            {/* PASSWORD */}
            <div>
              <label className="block mb-2 text-sm font-medium text-slate-700">
                Password
              </label>

              <div className="relative">
                <input
                  type={
                    showPassword
                      ? "text"
                      : "password"
                  }
                  value={password}
                  onChange={(e) =>
                    setPassword(e.target.value)
                  }
                  placeholder="Enter your password"
                  required
                  className="w-full h-12 px-4 pr-12 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0A6E8A] focus:border-transparent"
                />

                <button
                  type="button"
                  onClick={() =>
                    setShowPassword(!showPassword)
                  }
                  className="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600"
                >
                  {showPassword ? (
                    <EyeOff size={18} />
                  ) : (
                    <Eye size={18} />
                  )}
                </button>
              </div>
            </div>

            {/* OPTIONS */}
            <div className="flex items-center justify-between">
              <label className="flex items-center gap-2 text-sm text-slate-600">
                <input
                  type="checkbox"
                  checked={keepSignedIn}
                  onChange={(e) =>
                    setKeepSignedIn(
                      e.target.checked
                    )
                  }
                />
                Keep me signed in
              </label>

              <button
                type="button"
                className="text-sm text-[#0A6E8A] hover:underline"
              >
                Forgot Password?
              </button>
            </div>

            {/* LOGIN BUTTON */}
            <button
              type="submit"
              disabled={isLoading}
              className="w-full h-12 rounded-lg bg-[#0A6E8A] text-white font-semibold hover:bg-[#085A70] transition duration-200 disabled:opacity-50"
            >
              {isLoading
                ? "Signing In..."
                : "Sign In"}
            </button>
          </form>
        </div>
      </div>
    </div>
  );
}