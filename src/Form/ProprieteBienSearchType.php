<?php

namespace App\Form;

use App\Entity\ProprieteBienSearch;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprieteBienSearchType extends AbstractType
{

	/**
	 * @param string $placeholder
	 * @param bool $required
	 * @param bool $label
	 * @return array
	 */
	private function getConfig(string $placeholder, $required = false, $label = false)
	{
		return [
			'required' => $required,
			'label' => $label,
			'attr' => [
				'placeholder' => $placeholder
			]
		];
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice', IntegerType::class, $this->getConfig("Budget max"))
            ->add('minSurface', IntegerType::class, $this->getConfig("Surface min"))
            ->add('minRooms', IntegerType::class, $this->getConfig("Nombre de pièce min"))
            ->add('minBedrooms', IntegerType::class, $this->getConfig("Nombre de chambre min"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProprieteBienSearch::class,
			'method' => 'get',
			'csrf_protection' => false
        ]);
    }

    // url style
    public function getBlockPrefix()
	{
		return '';
	}
}
