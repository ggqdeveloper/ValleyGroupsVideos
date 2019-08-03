# ValleyGroupsVideos


[![Build Status](https://camo.githubusercontent.com/d5f565e42a90e1f23b7b0cf0821ecbfe8fa0af54/68747470733a2f2f706f7365722e707567782e6f72672f736c696d2f736c696d2f6c6963656e7365)]()

##Installation

It is recommended that you use Composer to install the libraries.

> php composer update

## UML diagrams

You can render UML diagrams using [Mermaid](https://mermaidjs.github.io/). For example, this will produce a sequence diagram:

```mermaid
sequenceDiagram
User ->> Video:   Creation of a new video
Video->>Comment: Creation of a new comment
Video-->>User : Return video
Comment-->>Video : Return comment
