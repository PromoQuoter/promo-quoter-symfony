<?php

namespace App\Entity;

use App\Repository\QuoteLayoutSettingRepository;
use App\Type\WithPicture;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteLayoutSettingRepository::class)]
class QuoteLayoutSetting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'quoteLayoutSetting', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(enumType: WithPicture::class)]
    private ?WithPicture $with_picture = WithPicture::WithPicture;

    #[ORM\Column]
    private ?bool $with_product_link = true;

    #[ORM\Column(length: 255)]
    private ?string $layout = 'default';

    #[ORM\Column(type: Types::TEXT)]
    private ?string $preview_footer = "<blockquote style=\"font-size: 13px; margin: 7px 0px 0px; padding: 6px 15px; line-height: 20px; text-align: center;\"><span style=\"font-size: 12px; font-family: Arial;\">All Quotes are valid for 30 days with the exception of USB quotes which are vaild for 7 days. Deposit of 50% is payable when order is placed with balance payable on delivery.</span></blockquote>";

    #[ORM\Column(type: Types::TEXT)]
    private ?string $preview_introduction = "<p></p><h5><span style=\"font-size:10.0pt;font-family:Abel\"><span style=\"font-family: Arial; font-size: 12px;\">Thank you
for your interest in our products. We are pleased to provide you with the
following quotation for your consideration.</span></span></h5><h5><span style=\"font-size: 12px; font-family: Arial;\">Please
don't hesitate to contact us if you have any questions.</span></h5><p></p>";

    #[ORM\Column(length: 7)]
    private ?string $preview_header_color = "#555d68";

    #[ORM\Column(length: 7)]
    private ?string $preview_header_bg_color = "#78b5f7";

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyId(): ?Company
    {
        return $this->company_id;
    }

    public function setCompanyId(Company $company_id): static
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getWithPicture(): ?WithPicture
    {
        return $this->with_picture;
    }

    public function setWithPicture(WithPicture $with_picture): static
    {
        $this->with_picture = $with_picture;

        return $this;
    }

    public function isWithProductLink(): ?bool
    {
        return $this->with_product_link;
    }

    public function setWithProductLink(bool $with_product_link): static
    {
        $this->with_product_link = $with_product_link;

        return $this;
    }

    public function getLayout(): ?string
    {
        return $this->layout;
    }

    public function setLayout(string $layout): static
    {
        $this->layout = $layout;

        return $this;
    }

    public function getPreviewFooter(): ?string
    {
        return $this->preview_footer;
    }

    public function setPreviewFooter(string $preview_footer): static
    {
        $this->preview_footer = $preview_footer;

        return $this;
    }

    public function getPreviewIntroduction(): ?string
    {
        return $this->preview_introduction;
    }

    public function setPreviewIntroduction(string $preview_introduction): static
    {
        $this->preview_introduction = $preview_introduction;

        return $this;
    }

    public function getPreviewHeaderColor(): ?string
    {
        return $this->preview_header_color;
    }

    public function setPreviewHeaderColor(string $preview_header_color): static
    {
        $this->preview_header_color = $preview_header_color;

        return $this;
    }

    public function getPreviewHeaderBgColor(): ?string
    {
        return $this->preview_header_bg_color;
    }

    public function setPreviewHeaderBgColor(string $preview_header_bg_color): static
    {
        $this->preview_header_bg_color = $preview_header_bg_color;

        return $this;
    }
}
