<?php

namespace App\Exports;

use App\Models\Cashflow;
use Maatwebsite\Excel\Concerns\{Exportable, FromQuery, WithMapping, WithHeadings, ShouldAutoSize};

class CashflowsExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;
    private $filters; 

    public function __construct($filters = null)
    {
        $this->filters = $filters; 
    }

    public function query()
    { 
        if($this->filters['from'] && $this->filters['to']){
            return Cashflow::query()->with('user')->whereBetween('created_at', [$this->filters['from'], $this->filters['to']]);   
        }elseif($this->filters['keywords']){
            return Cashflow::query()->with('user')->where('code', 'like', '%' . $this->filters['keywords'] . '%');
        }else{
            return Cashflow::query()->with('user');   
        }
    }

    public function map($cashflow): array
    { 
        return [
            $cashflow->id,
            $cashflow->code,
            $cashflow->name,
            $cashflow->user->username,
            $cashflow->type,
            $cashflow->value,
            $cashflow->created_at,
            $cashflow->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Transaction Code',
            'Transaction Name',
            'Username',
            'Type',
            'Value',
            'Created At',
            'Updated At',
        ];
    }
}
