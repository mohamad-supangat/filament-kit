import preset from "../../../../vendor/filament/filament/tailwind.config.preset";

const baseColors = ["green", "red", "yellow", "blue", "gray"];

const colorsSafelist = baseColors.flatMap((color) =>
    [100, 500, 800].flatMap((value) =>
        ["text", "bg", "hover:bg", "hover:text"].flatMap((type) => {
            return `${type}-${color}-${value}`;
        }),
    ),
);

export default {
    safelist: [
        ...colorsSafelist,
        "grid-cols-2",
        "grid-cols-3",
        "w-[75%]",
        "w-[60%]",
    ],
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/awcodes/filament-table-repeater/resources/**/*.blade.php",
    ],
};
