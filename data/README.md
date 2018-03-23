
# SiLVer: Symbolic links verifier

The Core Network Algebra (CNA) is a model for concurrency that extends the point-to-point communication discipline of <a href="https://en.wikipedia.org/wiki/Calculus_of_communicating_systems">Milner’s CCS</a> with multiparty interactions. Links are used to build chains describing how information flows among the different agents participating in a multiparty interaction.

SiLVer is a tool written in <a href="http://maude.cs.uiuc.edu">Maude</a> for the animation and verification of CNA processes. Currently, the tool allows for:

*  Defining processes and processes definitions.
* Generating traces from a given process. 
* Building the label transition system generated from a process (in the case of finite processes)
* Generating a <a href="https://en.wikipedia.org/wiki/DOT_(graph_description_language)">DOT</a> file with the transition system of a process.
* Specifying  properties of the system using Symbolic Link Modal Logic (SLML) and verify them using a model checking algorithm. 
* Checking whether 2 processes are network-bisimilar.

Details on the (symbolic) verification techniques for CNA processes can be found in: <i>
Linda Brodo, Carlos Olarte: Symbolic Semantics for Multiparty Interactions in the Link-Calculus. SOFSEM 2017: LNCS (10139), pages 62-75. Springer. 2017 (<a href="https://doi.org/10.1007/978-3-319-51963-0_6">DOI</a>). </i>

This package is free software; you can redistribute it and/or modify it under the terms of GNU Lesser General Public License (see the COPYING file). 

Author <a href="https://sites.google.com/site/carlosolarte/"> Carlos Olarte</a>


## Getting Started

The project was tested in Maude 2.7.1. No extra library is needed for execution. A tool such as <a href="http://graphviz.org">Graphviz</a> is needed for the visualization of the transition system. 

The implementation includes the following files:

- <b>links.maude</b>: defining names, links and link chains. 
- <b>configuration.maude</b>: defining symbolic configurations
- <b>processes.maude</b>: syntax for processes. 
- <b>semantics.maude</b>: symbolic semantics and procedures to extract the label transition system. 
- <b>modelchecking.maude</b>: definition of the logic and the model checker procedure based on <a href="http://maude.cs.illinois.edu/tools/lmc/">Maude's model checker</a> . 
- <b>examples.maude</b>: examples of processes and the verification techniques including:

```
----------------------------------------
--- 1. One step transitions
--- 2. Traces
--- 3. Label transition system and generation of a DOT file (graph)
--- 4. Model Checking
--- 5. Bisimulation
--- 6. Dinning Philosopher problem.
--- 7. (Bounded) Counter (a la CCS)
--- 8. Scheduler (a la CCS)
--- 9. Transportation system
--- 10. Peterson Algorithm
-----------------------------------------
```
