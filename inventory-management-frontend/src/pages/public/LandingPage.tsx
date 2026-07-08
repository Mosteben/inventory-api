import { useState } from "react";
import { Link } from "react-router-dom";
import { motion } from "framer-motion";
import {
    Boxes,
    Users2,
    Truck,
    BarChart3,
    ShieldCheck,
    Zap,
    ArrowRight,
    Menu,
    X,
    CheckCircle2,
} from "lucide-react";

import AnimatedStat from "../../components/ui/AnimatedStat";

import heroImg from "../../assets/illustrations/illustration-growth-steps.webp";
import workflowImg from "../../assets/illustrations/illustration-workflow-board.webp";
import handshakeImg from "../../assets/illustrations/illustration-handshake-deal.webp";
import printImg from "../../assets/illustrations/illustration-chat-print.webp";
import teamworkImg from "../../assets/illustrations/illustration-teamwork-thread.webp";
import trophyImg from "../../assets/illustrations/illustration-first-place-trophy.webp";
import remoteTeamImg from "../../assets/illustrations/illustration-remote-team.webp";
import lateNightImg from "../../assets/illustrations/illustration-late-night-work.webp";
import browsingImg from "../../assets/illustrations/illustration-website-browsing.webp";
import readingImg from "../../assets/illustrations/illustration-reading-book.webp";
import conversationImg from "../../assets/illustrations/illustration-conversation-bubble.webp";
import supportImg from "../../assets/illustrations/illustration-support-headset.webp";
import timeImg from "../../assets/illustrations/illustration-time-urgency.webp";

const fadeUp = {
    hidden: { opacity: 0, y: 26 },
    show: { opacity: 1, y: 0, transition: { duration: 0.6, ease: "easeInOut" as const } },
} as const;

const stagger = {
    hidden: {},
    show: { transition: { staggerChildren: 0.12 } },
};

const NAV_LINKS = [
    { label: "Product", href: "#product" },
    { label: "Features", href: "#features" },
    { label: "Roles", href: "#roles" },
    { label: "Reviews", href: "#reviews" },
];

// Major features, presented as alternating rows with the user's illustrations
const MAJOR_FEATURES = [
    {
        icon: Boxes,
        tag: "Live tracking",
        title: "Know your stock the second it changes",
        desc: "Every sale, return, or restock updates the dashboard instantly, no manual counts, no stale spreadsheets.",
        points: ["Automatic quantity sync", "Low-stock alerts", "Multi-location support"],
        img: workflowImg,
        blob: "#FFE1AE",
    },
    {
        icon: Truck,
        tag: "Suppliers",
        title: "Every supplier deal, organized in one place",
        desc: "Pricing, lead times, and purchase orders live next to the products they affect, so nothing gets renegotiated from memory.",
        points: ["Purchase order history", "Price comparisons", "Reorder reminders"],
        img: handshakeImg,
        blob: "#CFE6FF",
    },
    {
        icon: BarChart3,
        tag: "Billing",
        title: "Invoices your team can send in one click",
        desc: "Generate, print, or email an invoice the moment an order is confirmed. Customers see the same numbers your team does.",
        points: ["One-click invoicing", "Order status tracking", "Shareable receipts"],
        img: printImg,
        blob: "#FFD6E5",
    },
];

const SMALL_FEATURES = [
    { icon: Users2, title: "Team collaboration", desc: "Admins and staff work off the same live data.", img: teamworkImg },
    { icon: Zap, title: "Growth reports", desc: "See what's selling before your competitors do.", img: trophyImg },
    { icon: ShieldCheck, title: "Onboarding, made easy", desc: "Get your catalog imported in minutes.", img: readingImg },
    { icon: CheckCircle2, title: "Customer support", desc: "Built-in help, right where your team works.", img: supportImg },
];

const ROLES = [
    {
        title: "Admin",
        desc: "Full visibility into stock, staff, and revenue across every location, plus control over pricing and permissions.",
        img: remoteTeamImg,
        blob: "#CFE6FF",
    },
    {
        title: "Employee",
        desc: "A focused daily workspace: receive stock, fulfill orders, and update counts without waiting on the shop computer.",
        img: lateNightImg,
        blob: "#FFE1AE",
    },
    {
        title: "Customer",
        desc: "A clean storefront to browse the catalog, place an order, and track it, no phone calls needed.",
        img: browsingImg,
        blob: "#FFD6E5",
    },
];

function LandingPage() {
    const [menuOpen, setMenuOpen] = useState(false);

    return (
        <div className="min-h-screen bg-[#FBF9F6] font-[Inter,sans-serif] text-[#16171B] antialiased">

            {/* NAVBAR */}
            <header className="sticky top-0 z-40 border-b border-black/[0.06] bg-[#FBF9F6]/85 backdrop-blur-lg">
                <div className="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                    <div className="flex items-center gap-2">
                        <span className="grid h-8 w-8 place-items-center rounded-lg bg-[#16171B] font-[Sora,sans-serif] text-sm font-bold text-white">
                            I
                        </span>
                        <span className="font-[Sora,sans-serif] text-lg font-bold">Inventoryy</span>
                    </div>

                    <nav className="hidden items-center gap-8 text-sm font-medium text-[#6B7280] md:flex">
                        {NAV_LINKS.map((l) => (
                            <a key={l.label} href={l.href} className="transition hover:text-[#16171B]">
                                {l.label}
                            </a>
                        ))}
                    </nav>

                    <div className="hidden items-center gap-3 md:flex">
                        <Link to="/login" className="text-sm font-medium text-[#16171B]/70 transition hover:text-[#16171B]">
                            Log in
                        </Link>
                        <Link
                            to="/register"
                            className="group inline-flex items-center gap-1.5 rounded-full bg-[#16171B] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#16171B]/85"
                        >
                            Get started
                            <ArrowRight className="h-3.5 w-3.5 transition group-hover:translate-x-0.5" />
                        </Link>
                    </div>

                    <button className="md:hidden" onClick={() => setMenuOpen((v) => !v)} aria-label="Toggle menu">
                        {menuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
                    </button>
                </div>

                {menuOpen && (
                    <div className="border-t border-black/[0.06] px-6 py-4 md:hidden">
                        <div className="flex flex-col gap-4 text-sm">
                            {NAV_LINKS.map((l) => (
                                <a key={l.label} href={l.href} className="text-[#16171B]/70">
                                    {l.label}
                                </a>
                            ))}
                            <Link to="/login" className="text-[#16171B]/70">Log in</Link>
                            <Link to="/register" className="font-semibold text-[#16171B]">Get started →</Link>
                        </div>
                    </div>
                )}
            </header>

            {/* HERO */}
            <section id="product" className="mx-auto grid max-w-6xl items-center gap-14 px-6 pb-16 pt-16 md:grid-cols-2 md:pt-24">
                <motion.div initial="hidden" animate="show" variants={stagger}>
                    <motion.span
                        variants={fadeUp}
                        className="inline-flex items-center gap-2 rounded-full border border-black/10 bg-white px-3 py-1 text-xs font-medium text-[#6B7280]"
                    >
                        <span className="h-1.5 w-1.5 rounded-full bg-[#4EA8DE]" />
                        Built for admins, staff, and customers
                    </motion.span>

                    <motion.h1
                        variants={fadeUp}
                        className="mt-6 font-[Sora,sans-serif] text-4xl font-bold leading-[1.12] tracking-tight md:text-[3.4rem]"
                    >
                        Inventory management that keeps everyone
                        <span className="relative mx-2 inline-block">
                            in sync
                            <svg
                                viewBox="0 0 200 12"
                                className="absolute -bottom-1 left-0 w-full text-[#FFC93C]"
                                preserveAspectRatio="none"
                            >
                                <path d="M2 9 C 60 2, 140 2, 198 9" stroke="currentColor" strokeWidth="6" fill="none" strokeLinecap="round" />
                            </svg>
                        </span>
                    </motion.h1>

                    <motion.p variants={fadeUp} className="mt-6 max-w-lg text-lg leading-relaxed text-[#6B7280]">
                        One platform for your whole team. Stock levels, orders, and suppliers
                        update automatically, so nobody works off yesterday's numbers.
                    </motion.p>

                    <motion.div variants={fadeUp} className="mt-9 flex flex-wrap items-center gap-4">
                        <Link
                            to="/register"
                            className="group inline-flex items-center gap-2 rounded-full bg-[#16171B] px-6 py-3.5 font-semibold text-white shadow-lg shadow-black/10 transition hover:bg-[#16171B]/85"
                        >
                            Start free
                            <ArrowRight className="h-4 w-4 transition group-hover:translate-x-1" />
                        </Link>
                        <Link
                            to="/login"
                            className="rounded-full border border-black/10 bg-white px-6 py-3.5 font-semibold text-[#16171B] transition hover:border-black/20"
                        >
                            Log in
                        </Link>
                    </motion.div>
                </motion.div>

                <motion.div
                    initial={{ opacity: 0, scale: 0.9 }}
                    animate={{ opacity: 1, scale: 1 }}
                    transition={{ duration: 0.8, ease: [0.16, 1, 0.3, 1] }}
                    className="relative mx-auto w-full max-w-md"
                >
                    <div className="absolute -inset-10 -z-10 rounded-full bg-[#FFE1AE]/70 blur-3xl" />
                    <motion.img
                        src={heroImg}
                        alt="Inventory growth dashboard illustration"
                        animate={{ y: [0, -14, 0] }}
                        transition={{ duration: 5, repeat: Infinity, ease: "easeInOut" }}
                        className="w-full drop-shadow-xl"
                    />
                </motion.div>
            </section>

            {/* STATS */}
            <section className="border-y border-black/[0.06] bg-white py-14">
                <motion.div
                    initial="hidden"
                    whileInView="show"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={stagger}
                    className="mx-auto grid max-w-5xl grid-cols-2 gap-8 px-6 md:grid-cols-4"
                >
                    <motion.div variants={fadeUp}>
                        <AnimatedStat value={99.9} decimals={1} suffix="%" label="Uptime" valueClassName="text-[#16171B]" labelClassName="text-[#6B7280]" />
                    </motion.div>
                    <motion.div variants={fadeUp}>
                        <AnimatedStat value={12} suffix="K+" label="Orders tracked / mo" valueClassName="text-[#16171B]" labelClassName="text-[#6B7280]" />
                    </motion.div>
                    <motion.div variants={fadeUp}>
                        <AnimatedStat value={3} label="Roles, one platform" valueClassName="text-[#16171B]" labelClassName="text-[#6B7280]" />
                    </motion.div>
                    <motion.div variants={fadeUp}>
                        <AnimatedStat value={0.4} decimals={1} suffix="s" label="Avg. search time" valueClassName="text-[#16171B]" labelClassName="text-[#6B7280]" />
                    </motion.div>
                </motion.div>
            </section>

            {/* MAJOR FEATURES — alternating rows */}
            <section id="features" className="mx-auto max-w-6xl px-6 py-24">
                <motion.div
                    initial="hidden"
                    whileInView="show"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={fadeUp}
                    className="mx-auto max-w-xl text-center"
                >
                    <span className="text-xs font-semibold uppercase tracking-widest text-[#4EA8DE]">Features</span>
                    <h2 className="mt-3 font-[Sora,sans-serif] text-3xl font-bold md:text-4xl">
                        Everything the back office needs
                    </h2>
                </motion.div>

                <div className="mt-16 flex flex-col gap-24">
                    {MAJOR_FEATURES.map((f, i) => (
                        <motion.div
                            key={f.title}
                            initial="hidden"
                            whileInView="show"
                            viewport={{ once: true, margin: "-100px" }}
                            variants={stagger}
                            className={`grid items-center gap-12 md:grid-cols-2 ${i % 2 === 1 ? "md:[&>*:first-child]:order-2" : ""}`}
                        >
                            <motion.div variants={fadeUp} className="relative mx-auto w-full max-w-sm">
                                <div
                                    className="absolute -inset-8 -z-10 rounded-[2.5rem] blur-2xl"
                                    style={{ backgroundColor: f.blob, opacity: 0.6 }}
                                />
                                <img src={f.img} alt={f.title} className="w-full" />
                            </motion.div>

                            <motion.div variants={fadeUp}>
                                <div className="inline-flex items-center gap-2 rounded-full bg-[#16171B]/5 px-3 py-1 text-xs font-semibold text-[#16171B]/70">
                                    <f.icon className="h-3.5 w-3.5" />
                                    {f.tag}
                                </div>
                                <h3 className="mt-4 font-[Sora,sans-serif] text-2xl font-bold leading-snug md:text-3xl">
                                    {f.title}
                                </h3>
                                <p className="mt-3 text-[#6B7280] leading-relaxed">{f.desc}</p>
                                <ul className="mt-5 space-y-2.5">
                                    {f.points.map((p) => (
                                        <li key={p} className="flex items-center gap-2 text-sm font-medium text-[#16171B]/80">
                                            <CheckCircle2 className="h-4 w-4 shrink-0 text-[#4EA8DE]" />
                                            {p}
                                        </li>
                                    ))}
                                </ul>
                            </motion.div>
                        </motion.div>
                    ))}
                </div>

                {/* secondary features grid */}
                <motion.div
                    initial="hidden"
                    whileInView="show"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={stagger}
                    className="mt-24 grid gap-6 sm:grid-cols-2 lg:grid-cols-4"
                >
                    {SMALL_FEATURES.map((f) => (
                        <motion.div
                            key={f.title}
                            variants={fadeUp}
                            className="rounded-2xl border border-black/[0.06] bg-white p-6 text-center shadow-sm transition hover:-translate-y-1 hover:shadow-md"
                        >
                            <img src={f.img} alt="" className="mx-auto h-28 w-auto" />
                            <div className="mt-4 flex items-center justify-center gap-1.5">
                                <f.icon className="h-4 w-4 text-[#4EA8DE]" />
                                <h4 className="font-[Sora,sans-serif] font-semibold">{f.title}</h4>
                            </div>
                            <p className="mt-1.5 text-sm text-[#6B7280]">{f.desc}</p>
                        </motion.div>
                    ))}
                </motion.div>
            </section>

            {/* ROLES */}
            <section id="roles" className="bg-white py-24">
                <div className="mx-auto max-w-6xl px-6">
                    <motion.div
                        initial="hidden"
                        whileInView="show"
                        viewport={{ once: true, margin: "-100px" }}
                        variants={fadeUp}
                        className="mx-auto max-w-xl text-center"
                    >
                        <span className="text-xs font-semibold uppercase tracking-widest text-[#FF5C8A]">Access</span>
                        <h2 className="mt-3 font-[Sora,sans-serif] text-3xl font-bold md:text-4xl">
                            One workspace, scoped for everyone
                        </h2>
                    </motion.div>

                    <motion.div
                        initial="hidden"
                        whileInView="show"
                        viewport={{ once: true, margin: "-100px" }}
                        variants={stagger}
                        className="mt-14 grid gap-8 md:grid-cols-3"
                    >
                        {ROLES.map((r) => (
                            <motion.div
                                key={r.title}
                                variants={fadeUp}
                                className="relative rounded-3xl bg-[#FBF9F6] p-8 text-center transition hover:-translate-y-1.5"
                            >
                                <div
                                    className="absolute -inset-6 -z-10 rounded-[2.5rem] blur-2xl"
                                    style={{ backgroundColor: r.blob, opacity: 0.5 }}
                                />
                                <img src={r.img} alt={r.title} className="mx-auto h-40 w-auto" />
                                <h3 className="mt-5 font-[Sora,sans-serif] text-xl font-bold">{r.title}</h3>
                                <p className="mt-2 text-sm leading-relaxed text-[#6B7280]">{r.desc}</p>
                            </motion.div>
                        ))}
                    </motion.div>
                </div>
            </section>

            {/* REVIEWS */}
            <section id="reviews" className="mx-auto max-w-5xl px-6 py-24">
                <motion.div
                    initial="hidden"
                    whileInView="show"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={stagger}
                    className="grid items-center gap-12 md:grid-cols-2"
                >
                    <motion.div variants={fadeUp} className="relative mx-auto w-full max-w-sm">
                        <div className="absolute -inset-8 -z-10 rounded-[2.5rem] bg-[#CFE6FF]/70 blur-2xl" />
                        <img src={conversationImg} alt="" className="w-full" />
                    </motion.div>

                    <motion.div variants={fadeUp}>
                        <span className="text-xs font-semibold uppercase tracking-widest text-[#4EA8DE]">Reviews</span>
                        <h2 className="mt-3 font-[Sora,sans-serif] text-3xl font-bold md:text-4xl">What shop owners say</h2>
                        <p className="mt-6 text-lg italic leading-relaxed text-[#16171B]/80">
                            "Since we started using the system, we know what's running low before it
                            runs out, and our customers are noticeably happier."
                        </p>
                        <p className="mt-5 font-semibold">Mohamed Abdelrahman</p>
                        <p className="text-sm text-[#6B7280]">Owner, home goods store</p>
                    </motion.div>
                </motion.div>
            </section>

            {/* FINAL CTA */}
            <section className="mx-auto max-w-6xl px-6 pb-24">
                <motion.div
                    initial="hidden"
                    whileInView="show"
                    viewport={{ once: true, margin: "-100px" }}
                    variants={fadeUp}
                    className="relative overflow-hidden rounded-[2.5rem] bg-[#16171B] px-8 py-16 text-center text-white"
                >
                    <div className="pointer-events-none absolute -top-20 left-1/2 h-64 w-64 -translate-x-1/2 rounded-full bg-[#FFC93C]/25 blur-3xl" />
                    <div className="pointer-events-none absolute -bottom-24 right-1/4 h-56 w-56 rounded-full bg-[#4EA8DE]/25 blur-3xl" />
                    <img src={timeImg} alt="" className="mx-auto h-24 w-auto opacity-90" />
                    <h2 className="mt-6 font-[Sora,sans-serif] text-3xl font-bold md:text-4xl">
                        Stop guessing what's in stock
                    </h2>
                    <p className="mx-auto mt-3 max-w-md text-white/60">
                        Set up your workspace in minutes. No credit card required.
                    </p>
                    <div className="mt-8 flex flex-wrap items-center justify-center gap-4">
                        <Link
                            to="/register"
                            className="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3.5 font-semibold text-[#16171B] transition hover:bg-white/90"
                        >
                            Create free account
                            <ArrowRight className="h-4 w-4" />
                        </Link>
                        <Link
                            to="/login"
                            className="rounded-full border border-white/20 px-6 py-3.5 font-semibold text-white transition hover:border-white/40"
                        >
                            Log in
                        </Link>
                    </div>
                </motion.div>
            </section>

            {/* FOOTER */}
            <footer className="border-t border-black/[0.06] py-10">
                <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-6 text-sm text-[#6B7280] md:flex-row">
                    <span>© {new Date().getFullYear()} Inventoryy. All rights reserved.</span>
                    <div className="flex items-center gap-6">
                        <Link to="/login" className="hover:text-[#16171B]">Log in</Link>
                        <Link to="/register" className="hover:text-[#16171B]">Register</Link>
                    </div>
                </div>
            </footer>

        </div>
    );
}

export default LandingPage;
