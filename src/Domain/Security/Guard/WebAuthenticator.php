<?php
namespace App\Domain\Security\Guard;

use App\Domain\Security\DataTransferObject\Credentials;
use App\Domain\Security\Form\LoginType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;

class WebAuthenticator extends AbstractFormLoginAuthenticator
{
    private UrlGeneratorInterface $urlGenerator;

    private FormFactoryInterface $formFactory;

    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(
        UrlGeneratorInterface $urlGenerator,
        FormFactoryInterface $formFactory,
        UserPasswordEncoderInterface $userPasswordEncoder
    ){
        $this->urlGenerator = $urlGenerator;
        $this->formFactory = $formFactory;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }


    /**
     * @inheritDoc
     */
    protected function getLoginUrl() : string
    {
        return $this->urlGenerator->generate('security_login');
    }

    /**
     * @inheritDoc
     */
    public function supports(Request $request) : bool
    {
        return $request->isMethod(Request::METHOD_POST)
            && $request->attributes->get('_route') === 'security_login';
    }

    /**
     * @inheritDoc
     */
    public function getCredentials(Request $request) : ?Credentials
    {
        $credentials = new Credentials('');
        $form = $this->formFactory->create(LoginType::class, $credentials)->handleRequest($request);

        if (!$form->isValid()) {
            return null;
        }

        return $credentials;
    }

    /**
     * @param Credentials $credentials
     */
    public function getUser($credentials, UserProviderInterface $userProvider) : ?UserInterface
    {
        return $userProvider->loadUserByUsername($credentials->getUsername());
    }

    /**
     * @inheritDoc
     * @param Credentials $credentials
     */
    public function checkCredentials($credentials, UserInterface $user) : bool
    {
        if ($this->userPasswordEncoder->isPasswordValid($user, $credentials->getPassword())) {
            return true;
        }

        throw new AuthenticationException('Password not valid');
    }

    /**
     * @inheritDoc
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey) :RedirectResponse
    {
        return new RedirectResponse($this->urlGenerator->generate('blog'));
    }
}
