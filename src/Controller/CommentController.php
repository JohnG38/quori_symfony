<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Question;
use App\Entity\Vote;
use App\Repository\VoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CommentController extends AbstractController
{
    #[Route('comment/rating/{id}/{score}', name: 'comment_rating')]
    #[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
    public function rate(Request $request, Comment $comment, int $score, EntityManagerInterface $em, Question $question, VoteRepository $voteRepository) {

        $currentUser = $this->getUser();

        // je verifie que le currentUser n'est pas le proprietaire de la reponse
        if($currentUser !== $comment->getAuthor()) {

            // on verifie que le currentUser a deja voté
            $vote = $voteRepository->findOneBy([
                'author' => $currentUser,
                'comment' => $comment
            ]);

            if($vote) {
                // si il a aimé la réponse et qu'il reclique sur le like c'est pour annuler son vote
                // ou   
                // si il n'a pas aimé la reponse et qu'il reclique sur le dislike c'est pour annuler son vote
                if(($vote->getIsLiked() && $score > 0 || (!$vote->getIsLiked() && $score < 0))) {
                    // on supprime le vote
                    $em->remove($vote);
                    $comment->setRating($comment->getRating()+ ($score > 0 ? -1 : 1));
                } else {
                    $vote->setIsLiked(!$vote->getIsLiked());
                    $comment->setRating($comment->getRating()+ ($score > 0 ? 2 : -2));

                }
            } else {
                // on le laisse voter
                $newVote =  new Vote();
                $newVote->setAuthor($currentUser)
                        ->setComment($comment)
                        ->setIsLiked($score > 0 ? true : false);
                        
                $em->persist($newVote);
                $comment->setRating($comment->getRating() + $score);
            }

            $em->flush();


        }
        
        $referer = $request->server->get('HTTP_REFERER');
        return $referer ? $this->redirect($referer) : $this->redirectToRoute(('home'));

    }

}
