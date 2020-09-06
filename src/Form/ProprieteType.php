<?php

namespace App\Form;

use App\Entity\ProprieteBien;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprieteType extends AbstractType
{

	/**
	 * @param string $label
	 * @param bool $required
	 * @return array
	 */
	private function getConfig(string $label, $required = true){
		return [
			'label' => $label,
			'required' => $required
		];
	}

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class, $this->getConfig("Image de la Propriété", false))
            ->add('name', TextType::class, $this->getConfig("Nom"))
            ->add('description', TextareaType::class, $this->getConfig("Description"))
            ->add('city', TextType::class, $this->getConfig("Ville"))
            ->add('address', TextType::class, $this->getConfig("Adresse"))
            ->add('zip_code', IntegerType::class, $this->getConfig("Code postal"))
            ->add('nbr_rooms', IntegerType::class, $this->getConfig("Nombre de pièces"))
            ->add('surface', IntegerType::class, $this->getConfig("Surface"))
            ->add('nbr_bedrooms', IntegerType::class, $this->getConfig("Nombre de chambres"))
            ->add('price', MoneyType::class, $this->getConfig("Prix"))
            ->add('sold', CheckboxType::class, $this->getConfig("Vendu", false))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProprieteBien::class,
        ]);
    }
}
