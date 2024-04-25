<?php

namespace App\Http\Controllers;

use App\Http\PagedIndexes\RecordPagedIndex;
use App\Http\Requests\RecordRequest;
use App\Models\Record;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RecordController extends Controller
{
    public function index(): Response
    {
        return new Response(RecordPagedIndex::all());
    }

    public function show(Record $record): Response
    {
        return new Response($record);
    }

    public function store(RecordRequest $request): Response
    {
        $record = Record::create($request->validated());
        return new Response($record, Response::HTTP_CREATED);
    }

    public function update(Record $record, RecordRequest $request): Response
    {
        $record->update($request->validated());
        return new Response($record);
    }

    public function destroy(Record $record): Response
    {
        $record->delete();
        return new Response($record);
    }
}
