<?php

namespace App\Livewire;

use Livewire\Component;

class OptionPicker extends Component
{
    public $selectedValue = '';
    public $selectedLabel = '';
    public $searchTerm = '';
    public $isOpen = false;
    public $fieldName = 'option';
    public $placeholder = 'اختر خياراً';
    public $label = 'الخيار';
    public $options = [];
    public $displayType = 'text'; // text, icon, image, color, badge, custom
    public $searchable = true;
    public $multiple = false;
    public $selectedOptions = [];
    public $maxSelections = null;
    public $emptyMessage = 'لا توجد خيارات متاحة';
    public $searchPlaceholder = 'ابحث...';

    protected $listeners = ['clearSelection', 'setOptions'];

    public function mount($options = [], $selectedValue = '', $fieldName = 'option', $placeholder = 'اختر خياراً', $label = 'الخيار', $displayType = 'text', $searchable = true, $multiple = false, $maxSelections = null)
    {
        $this->options = $this->formatOptions($options);
        $this->selectedValue = $selectedValue;
        $this->fieldName = $fieldName;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->displayType = $displayType;
        $this->searchable = $searchable;
        $this->multiple = $multiple;
        $this->maxSelections = $maxSelections;
        
        if ($this->multiple && $selectedValue) {
            $this->selectedOptions = is_array($selectedValue) ? $selectedValue : [$selectedValue];
        }
        
        $this->updateSelectedLabel();
    }

    private function formatOptions($options)
    {
        if (empty($options)) {
            return [];
        }

        // If it's already formatted correctly, return as is
        if (isset($options[0]['value']) && isset($options[0]['label'])) {
            return $options;
        }

        $formatted = [];
        foreach ($options as $key => $value) {
            if (is_array($value)) {
                // Handle grouped options or complex arrays
                if (isset($value['value']) && isset($value['label'])) {
                    $formatted[] = $value;
                } else {
                    // Try to extract value and label from array
                    $formatted[] = [
                        'value' => $value['id'] ?? $value['value'] ?? $key,
                        'label' => $value['name'] ?? $value['label'] ?? $value['title'] ?? $key,
                        'icon' => $value['icon'] ?? null,
                        'image' => $value['image'] ?? null,
                        'color' => $value['color'] ?? null,
                        'description' => $value['description'] ?? null,
                        'category' => $value['category'] ?? null,
                    ];
                }
            } else {
                // Simple key-value pair
                $formatted[] = [
                    'value' => $key,
                    'label' => $value,
                    'icon' => null,
                    'image' => null,
                    'color' => null,
                    'description' => null,
                    'category' => null,
                ];
            }
        }

        return $formatted;
    }

    public function selectOption($value, $label = null)
    {
        if ($this->multiple) {
            if (in_array($value, $this->selectedOptions)) {
                // Remove if already selected
                $this->selectedOptions = array_filter($this->selectedOptions, fn($item) => $item !== $value);
            } else {
                // Add if not at max limit
                if (!$this->maxSelections || count($this->selectedOptions) < $this->maxSelections) {
                    $this->selectedOptions[] = $value;
                }
            }
            $this->selectedValue = $this->selectedOptions;
        } else {
            $this->selectedValue = $value;
            $this->selectedLabel = $label;
            $this->isOpen = false;
        }

        $this->updateSelectedLabel();
        
        $this->dispatch('optionSelected', [
            'value' => $this->selectedValue,
            'label' => $this->selectedLabel,
            'fieldName' => $this->fieldName,
            'multiple' => $this->multiple,
            'selectedOptions' => $this->selectedOptions
        ]);
    }

    public function removeOption($value)
    {
        if ($this->multiple) {
            $this->selectedOptions = array_filter($this->selectedOptions, fn($item) => $item !== $value);
            $this->selectedValue = $this->selectedOptions;
            $this->updateSelectedLabel();
            
            $this->dispatch('optionSelected', [
                'value' => $this->selectedValue,
                'label' => $this->selectedLabel,
                'fieldName' => $this->fieldName,
                'multiple' => $this->multiple,
                'selectedOptions' => $this->selectedOptions
            ]);
        }
    }

    private function updateSelectedLabel()
    {
        if ($this->multiple) {
            if (empty($this->selectedOptions)) {
                $this->selectedLabel = '';
            } else {
                $selectedLabels = [];
                foreach ($this->selectedOptions as $value) {
                    $option = collect($this->options)->firstWhere('value', $value);
                    if ($option) {
                        $selectedLabels[] = $option['label'];
                    }
                }
                $this->selectedLabel = implode(', ', $selectedLabels);
            }
        } else {
            if ($this->selectedValue) {
                $option = collect($this->options)->firstWhere('value', $this->selectedValue);
                $this->selectedLabel = $option['label'] ?? $this->selectedValue;
            }
        }
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->searchTerm = '';
    }

    public function clearSelection()
    {
        $this->selectedValue = $this->multiple ? [] : '';
        $this->selectedOptions = [];
        $this->selectedLabel = '';
        
        $this->dispatch('optionSelected', [
            'value' => $this->selectedValue,
            'label' => $this->selectedLabel,
            'fieldName' => $this->fieldName,
            'multiple' => $this->multiple,
            'selectedOptions' => $this->selectedOptions
        ]);
    }

    public function setOptions($options)
    {
        $this->options = $this->formatOptions($options);
    }

    public function getFilteredOptions()
    {
        if (empty($this->searchTerm)) {
            return $this->options;
        }

        return array_filter($this->options, function($option) {
            return stripos($option['label'], $this->searchTerm) !== false ||
                   (isset($option['description']) && stripos($option['description'], $this->searchTerm) !== false);
        });
    }

    public function isSelected($value)
    {
        if ($this->multiple) {
            return in_array($value, $this->selectedOptions);
        }
        return $this->selectedValue == $value;
    }

    public function render()
    {
        return view('livewire.option-picker', [
            'filteredOptions' => $this->getFilteredOptions()
        ]);
    }
} 