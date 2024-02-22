# (slug: native-elements-props)

```jsx
interface CardCtaProps extends React.AnchorHTMLAttributes<HTMLAnchorElement> {
	children: React.ReactNode;
}
Card.Cta = function CardCta({ children, ...rest }: CardCtaProps) {
	return (
		<a
			href={rest.href}
			className="relative z-10 mt-4 flex items-center text-sm font-medium text-teal-500"
		>
			{children}
			<ChevronRightIcon className="ml-1 h-4 w-4 stroke-current" />
		</a>
	);
};
```
