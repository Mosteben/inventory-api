import { Link } from "react-router-dom";

import RegisterForm from "../../components/forms/RegisterForm";
import readingImg from "../../assets/illustrations/illustration-reading-book.webp";

function RegisterPage() {

    return (

        <div className="min-h-screen bg-[#FBF9F6] font-[Inter,sans-serif] text-[#16171B]">

            <div className="grid min-h-screen md:grid-cols-2">

                {/* BRAND SIDE */}
                <div className="relative hidden flex-col justify-between overflow-hidden border-r border-black/[0.06] bg-white p-12 md:flex">
                    <Link to="/" className="flex items-center gap-2">
                        <span className="grid h-8 w-8 place-items-center rounded-lg bg-[#16171B] font-[Sora,sans-serif] text-sm font-bold text-white">
                            I
                        </span>
                        <span className="font-[Sora,sans-serif] text-lg font-bold">Inventoryy</span>
                    </Link>

                    <div className="relative mx-auto w-full max-w-sm">
                        <div className="absolute -inset-10 -z-10 rounded-full bg-[#FFE1AE]/60 blur-3xl" />
                        <img src={readingImg} alt="Onboarding illustration" className="w-full" />
                        <h2 className="mt-6 max-w-sm font-[Sora,sans-serif] text-2xl font-bold leading-tight">
                            Set up your workspace in minutes.
                        </h2>
                        <p className="mt-3 max-w-sm text-[#6B7280]">
                            Import your catalog and invite your team with the right role.
                        </p>
                    </div>

                    <p className="text-xs text-[#6B7280]">© {new Date().getFullYear()} Inventoryy</p>
                </div>

                {/* FORM SIDE */}
                <div className="flex items-center justify-center p-8">
                    <div className="w-full max-w-[400px]">

                        <Link
                            to="/"
                            className="mb-8 inline-block text-sm font-medium text-[#6B7280] transition hover:text-[#16171B]"
                        >
                            ← Back to home
                        </Link>

                        <h1 className="font-[Sora,sans-serif] text-3xl font-bold">
                            Create your account
                        </h1>
                        <p className="mt-2 text-sm text-[#6B7280]">
                            No credit card required.
                        </p>

                        <div className="mt-8">
                            <RegisterForm />
                        </div>

                        <p className="mt-6 text-center text-sm text-[#6B7280]">
                            Already have an account?{" "}
                            <Link to="/login" className="font-semibold text-[#16171B] hover:underline">
                                Log in
                            </Link>
                        </p>

                    </div>
                </div>

            </div>

        </div>

    );

}

export default RegisterPage;
