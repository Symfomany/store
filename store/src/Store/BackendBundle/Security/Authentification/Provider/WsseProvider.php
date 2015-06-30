<?php
// src/Acme/DemoBundle/Security/Authentication/Provider/WsseProvider.php
namespace Store\BackendBundle\Security\Authentification\Provider;

use Store\BackendBundle\Security\Authentification\Token\WsseUserToken;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\NonceExpiredException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;


/**
 * Le fournisseur d'authentification va effectuer la vérification du WsseUserToken. C'est-à-dire que le fournisseur va vérifier que la valeur de l'en-tête Created est valide dans les cinq minutes, que la valeur de l'en-tête Nonce est unique dans les cinq minutes, et que la valeur de l'en-tête PasswordDigest correspond au mot de passe de l'utilisateur.
 * Class WsseProvider
 * @package Store\BackendBundle\Security\Authentication\Provider
 */
class WsseProvider implements AuthenticationProviderInterface
{
    private $userProvider;
    private $cacheDir;

    /**
     * Use provider & cache
     * @param UserProviderInterface $userProvider
     * @param $cacheDir
     */
    public function __construct(UserProviderInterface $userProvider, $cacheDir)
    {
        $this->userProvider = $userProvider;
        $this->cacheDir     = $cacheDir;
    }

    /**
     * @param TokenInterface $token
     * AUthentification via le token
     * @return WsseUserToken
     */
    public function authenticate(TokenInterface $token)
    {

        $user = $this->userProvider->loadUserByUsername($token->getUsername());

        if ($user && $this->validateDigest($token->digest, $token->nonce, $token->created, $user->getPassword())) {
            $authenticatedToken = new WsseUserToken($user->getRoles());
            $authenticatedToken->setUser($user);

            return $authenticatedToken;
        }

        throw new AuthenticationException('The WSSE authentication failed.');
    }

    protected function validateDigest($digest, $nonce, $created, $secret)
    {
        // Expire le timestamp après 5 minutes
        if (time() - strtotime($created) > 6000) {
            return false;
        }

        // Valide que le nonce est unique dans les 5 minutes
        if (file_exists($this->cacheDir.'/'.$nonce) && file_get_contents($this->cacheDir.'/'.$nonce) + 300 > time()) {
            throw new NonceExpiredException('Previously used nonce detected');
        }
        file_put_contents($this->cacheDir.'/'.$nonce, time());

        // Valide le Secret
        $expected = base64_encode(sha1($nonce.$created.$secret, true));

        return $digest === $expected;
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof WsseUserToken;
    }
}