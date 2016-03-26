class ProgrammerType < ActiveRecord::Base
  has_one :programmer

  attr_accessible :name
end