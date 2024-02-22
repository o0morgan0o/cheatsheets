# Nice Features

```jsx
elements.map((el)=>{
  <div className="first:bg-red-900 odd:text-2xl even:text-3xl disabled:bg-gray focus:ring-4">Hello</div>
})

# style based on parent state, use "group" in parent and "group-hover" in children (or "group-focus" or "gropu-active" or "group-odd")
<a href="#" class="group block max-w-xs mx-auto rounded-lg p-6 bg-white ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-sky-500 hover:ring-sky-500">
  <div class="flex items-center space-x-3">
    <svg class="h-6 w-6 stroke-sky-500 group-hover:stroke-white" fill="none" viewBox="0 0 24 24"><!-- ... --></svg>
    <h3 class="text-slate-900 group-hover:text-white text-sm font-semibold">New project</h3>
    </div>
  <p class="text-slate-500 group-hover:text-white text-sm">Create a new project from a variety of starting templates.</p>
</a>
```

# nested named groups, use "group/<name>", like "group/item" or "group/edit"
```jsx
<ul role="list">
  {#each people as person}
  <li class="group/item hover:bg-slate-100 ...">
    <img src="{person.imageUrl}" alt="" />
    <div>
      <a href="{person.url}">{person.name}</a>
      <p>{person.title}</p>
    </div>
    <a class="group/edit invisible hover:bg-slate-200 group-hover/item:visible ..." href="tel:{person.phone}">
      <span class="group-hover/edit:text-gray-700 ...">Call</span>
      <svg class="group-hover/edit:translate-x-0.5 group-hover/edit:text-slate-500 ...">
      <!-- ... -->
      </svg>
    </a>
  </li>
  {/each}
</ul>
```

# group depuis une class
```jsx
<div class="group is-published">
  <div class="hidden group-[.is-published]:hover">
    Published
  </div>
</div>`
```

# sibling state
```jsx
<form>
  <label class="block">
    <span class="block text-sm font-medium text-slate-700">Email</span>
    <input type="email" class="peer ..."/>
    <p class="mt-2 invisible peer-invalid:visible text-pink-600 text-sm">
      Please provide a valid email address.
    </p>
  </label>
</form>
```

# styling based on descendants ("has-[:checked]" or "has-[:focus]" or "group-has-[a]:block")
```jsx
<label class="has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-900 has-[:checked]:ring-indigo-200 ..">
  <svg fill="currentColor">
  </svg>
  Google Pay
  <input type="radio" class="checked:border-indigo-500 ..." />
</label>
```

# first line and first Letter
```jsx
<p class="first-line:uppercase first-line:tracking-widest
  first-letter:text-7xl first-letter:font-bold first-letter:text-white
  first-letter:mr-3 first-letter:float-left
">
  Well, let me tell you something, funny boy. Y'know that little stamp, the one
  that says "New York Public Library"? Well that may not mean anything to you,
  but that means a lot to me. One whole hell of a lot.
</p>
```


# dialog backdrops
```jsx
<dialog class="backdrop:bg-gray-50">
  <form method="dialog">
    <!-- ... -->
  </form>
</dialog>

# empty , style an element if it has no children
<ul>
  {#each people as person}
    <li class="empty:hidden ...">{person.hobby}</li>
  {/each}
</ul>
```

# colors for css variables
```css
@tailwind base;
@tailwind components;
@tailwind utilities;
@layer base {
  :root {
    --color-primary: 255 115 179;
    --color-secondary: 111 114 185;
    /* ... */
  }
}
```

```jsx
/** @type {import('tailwindcss').Config} */
module.exports = {
  theme: {
    colors: {
      // Using modern `rgb`
      primary: 'rgb(var(--color-primary) / <alpha-value>)',
      secondary: 'rgb(var(--color-secondary) / <alpha-value>)',

      // Using modern `hsl`
      primary: 'hsl(var(--color-primary) / <alpha-value>)',
      secondary: 'hsl(var(--color-secondary) / <alpha-value>)',

      // Using legacy `rgba`
      primary: 'rgba(var(--color-primary), <alpha-value>)',
      secondary: 'rgba(var(--color-secondary), <alpha-value>)',
    }
  }
}
```
