# Avec tailwindCss

`fonts.css`:
```css
@font-face {
  font-display: swap;
  font-family: 'Josefin Sans';
  font-style: normal;
  font-weight: 300;
  src: url("./../fonts/JosefinSans-Light.ttf")
}
...
```

`app.css`:
```css
@import 'fonts.css';
@tailwind base;
@tailwind components;
@tailwind utilities;
*{
  @apply font-josefinSlab
}
```

```js
/** @type {import('tailwindcss').Config} config */
const config = {
    content: ["./app/**/*.php", "./resources/**/*.{php,vue,js}"],
    theme: {
        extend: {
            colors: {},
            fontFamily: {
                josefinSans: ["Josefin Sans", "sans-serif"],
                josefinSlab: ["Josefin Slab", "serif"],
            },
        },
    },
    plugins: [],
};
export default config;
```
