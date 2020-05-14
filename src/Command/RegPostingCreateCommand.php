<?php

namespace App\Command;

use App\Entity\Account;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Posting;
use App\Lib\Interfaces\DictionaryInterface;
use App\Lib\PostingType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class RegPostingCreateCommand extends Command
{
    protected static $defaultName = 'reg:posting:create';

    private Account $account;
    private Category $category;
    private float $money;
    private int $type;
    private ?string $comment;
    private \DateTimeInterface $date;

    private QuestionHelper $helper;

    private ManagerRegistry $mr;

    /**
     * @required
     */
    public function setManagerRegistry(ManagerRegistry $managerRegistry): void
    {
        $this->mr = $managerRegistry;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add payment')
            ->addOption('account', null, InputOption::VALUE_REQUIRED, 'Posting account id')
            ->addOption('category', null, InputOption::VALUE_REQUIRED, 'Posting category id')
            ->addOption('money', null, InputOption::VALUE_REQUIRED, 'Posting money')
            ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Posting type')
            ->addOption('comment', null, InputOption::VALUE_REQUIRED, 'Posting comment')
            ->addOption(
                'dateOperation',
                null,
                InputOption::VALUE_OPTIONAL,
                'Posting date operation');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->helper = $this->getHelper('question');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $this->account = $this->extractAccount($input, $output);
        $this->category = $this->extractCategory($input, $output);
        $this->money = $this->extractMoney($input, $output);
        $this->type = $this->extractType($input, $output);
        $this->comment = $input->getOption('comment');
        $this->date = $this->extractDateOperation($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $posting = new Posting();
        $posting
            ->setAccount($this->account)
            ->setCategory($this->category)
            ->setType($this->type)
            ->setMoney($this->money)
            ->setDateOperation($this->date);

        if ($this->comment !== null) {
            $comment = new Comment();
            $comment->setComment($this->comment);

            $posting->setComment($comment);
        }

        $em = $this->mr->getManager();
        $em->persist($posting);
        $em->flush();

        return 0;
    }

    private function extractDateOperation(InputInterface $input, OutputInterface $output): \DateTimeInterface
    {
        $date = $input->getOption('dateOperation');

        if (null === $date) {
            return new \DateTime('now');
        }

        return new \DateTime($date);
    }

    private function extractType(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getOption('type');
        $types = PostingType::getAllTypes();

        if (!(is_numeric($type) && isset($types[(int) $type]))) {
            $question = new ChoiceQuestion('Choice type: ', $types);
            $type = array_search($this->helper->ask($input, $output, $question), $types);
        }

        return (int) $type;
    }

    private function extractMoney(InputInterface $input, OutputInterface $output): float
    {
        $money = $input->getOption('money');

        if (!is_numeric($money)) {
            $question = new Question('Enter money: ');
            $question->setValidator(function ($answer) {
                if (!is_numeric($answer)) {
                    throw new \RuntimeException('it is not money');
                }

                return $answer;
            });

            $money = $this->helper->ask($input, $output, $question);
        }

        return (float) $money;
    }

    private function extractCategory(InputInterface $input, OutputInterface $output): Category
    {
        /** @var CategoryRepository $categoryRepo */
        $categoryRepo = $this->mr->getRepository(Category::class);

        return $this->extractDictionary(
            $categoryRepo->findByAccount($this->account),
            $this->formatterOptionDictionary($input->getOption('category')),
            $input,
            $output
        );

    }

    private function extractAccount(InputInterface $input, OutputInterface $output): Account
    {
        $accountRepo = $this->mr->getRepository(Account::class);

        return $this->extractDictionary(
            $accountRepo->findAll(),
            $this->formatterOptionDictionary($input->getOption('account')),
            $input,
            $output
        );
    }

    private function extractDictionary(
        array $listDictionary,
        ?int $dictionaryId,
        InputInterface $input,
        OutputInterface $output
    ): DictionaryInterface {
        $list = [];

        /** @var DictionaryInterface $dictionary */
        foreach ($listDictionary as $dictionary) {
            $list[$dictionary->getId()] = $dictionary;
        }

        $dictionaryName = null;
        if (!(null === $dictionaryId && in_array((int)$dictionaryId, array_keys($list)))) {
            $question = new ChoiceQuestion(
                sprintf('Choice %s: ', $dictionary instanceof Account ? 'account' : 'category'),
                array_map(fn(DictionaryInterface $dictionary) => $dictionary->getName(), $list)
            );

            $dictionaryName = $this->helper->ask($input, $output, $question);
        }

        if ($dictionaryName !== null) {
            $needle = $dictionaryName;
            $funcName = 'getName';
        } else {
            $needle = $dictionaryId;
            $funcName = 'getId';
        }

        $selectedDictionary = null;
        /** @var DictionaryInterface $account */
        foreach ($list as $dictionary) {
            if ($dictionary->$funcName() === $needle) {
                $selectedDictionary = $dictionary;
                break;
            }
        }

        return $selectedDictionary;
    }

    private function formatterOptionDictionary(?string $option): ?int
    {
        if (is_numeric($option)) {
            return (int)$option;
        }

        return null;
    }
}
