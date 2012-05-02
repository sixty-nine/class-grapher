The parsing process
===================

The parsing process consist in three phases:

    1) Create a reader for the text to parse, which will produce a ReaderInterface instance
    2) Scan the reader, which will produce a TokenQueue instance
    3) Parse the token queue, which will produce a root SyntaxTreeNode
