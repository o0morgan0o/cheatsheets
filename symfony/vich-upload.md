# Add file upload to entity

## Configuration

```php
vich_uploader:
    db_driver: orm

    metadata:
        type: attribute

    mappings:
        user_thumbnails:
            uri_prefix: /images/users/thumbnails
            upload_destination: '%kernel.project_dir%/public/images/users/thumbnails'
            namer: Vich\UploaderBundle\Naming\SmartUniqueNamer

            inject_on_load: false
            delete_on_update: true
            delete_on_remove: true

```

## Entity

```php
<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: 'user_thumbnails', fileNameProperty: 'userThumbnailName',size:'userThumbnailSize')]
    private ?File $userThumbnailFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $userThumbnailName = null;

    #[ORM\Column(nullable: true)]
    private ?int $userThumbnailSize = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function setUserThumbnailFile(?File $imageFile = null): void
    {
        $this->userThumbnailFile = $imageFile;
        if(null !== $imageFile){
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getUserThumbnailFile(): ?File
    {
        return $this->userThumbnailFile;
    }

    public function setUserThumbnailName(?string $imageName): void
    {
        $this->userThumbnailName = $imageName;
    }

    public function getUserThumbnailName(): ?string
    {
        return $this->userThumbnailName;
    }

    public function setUserThumbnailSize(?int $imageSize): void
    {
        $this->userThumbnailSize = $imageSize;
    }

    public function getUserThumbnailSize(): ?int
    {
        return $this->userThumbnailSize;
    }



    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
```

## And in the controller

```php
<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createFormBuilder($user)
            ->add('userThumbnailFile', VichImageType::class, [
                'required' => true,
                'allow_delete' => true,
                'delete_label' =>'delete',
                'asset_helper' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Update'])
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $updatedUser =$form->get('userThumbnailFile')->getData();
            $user = $this->getUser();
            $user->setUserThumbnailFile($updatedUser);
            $em->persist($user);
            $em->flush();
        }

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form' => $form
        ]);
    }
}
```

## Show image preview in form

For this override the template theme of the `ImageType`, in the `easycorp/easyadmin-bundle/src/Resources/views/crud/form_theme.html.twig` :

```twig
...
{% block ea_fileupload_widget %}
    ADD THIS ----> <img src="/images/users/thumbnails/{{ (currentFiles|first).filename }}"/>
    <h1>{{ (currentFiles|first).filename }}</h1>
    <div class="ea-fileupload">
...
...

```
