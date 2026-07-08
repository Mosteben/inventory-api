import { useEffect, useRef, useState } from "react";
import { animate, useInView } from "framer-motion";

interface AnimatedStatProps {
    value: number;
    suffix?: string;
    prefix?: string;
    decimals?: number;
    label: string;
    valueClassName?: string;
    labelClassName?: string;
}

function AnimatedStat({
    value,
    suffix = "",
    prefix = "",
    decimals = 0,
    label,
    valueClassName = "text-white",
    labelClassName = "text-white/50",
}: AnimatedStatProps) {
    const ref = useRef<HTMLDivElement>(null);
    const isInView = useInView(ref, { once: true, margin: "-80px" });
    const [display, setDisplay] = useState(0);

    useEffect(() => {
        if (!isInView) return;

        const controls = animate(0, value, {
            duration: 1.6,
            ease: [0.16, 1, 0.3, 1],
            onUpdate: (v) => setDisplay(v),
        });

        return () => controls.stop();
    }, [isInView, value]);

    return (
        <div ref={ref} className="text-center">
            <div className={`font-[JetBrains_Mono,monospace] text-3xl font-bold md:text-4xl ${valueClassName}`}>
                {prefix}
                {display.toFixed(decimals)}
                {suffix}
            </div>
            <div className={`mt-1 text-sm ${labelClassName}`}>{label}</div>
        </div>
    );
}

export default AnimatedStat;
