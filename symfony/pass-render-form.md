# To pass form created by twig

```php
<?php
  $form = $this->createFormBuilder()
    ->add('userThumbnailFile', VichImageType::class, [
      ...
    ])
    ->add('save', SubmitType::class, ['label'=>'submit'])
    ->getForm();

...
return $this->json([
  'form' => $this->renderView('profile/view.html.twig', [
    'form' => $form->createView()
    ]
  ]);

```

And the form in the template `profile/view.html.twig` :

```twig
{{ form(form) }}
```
