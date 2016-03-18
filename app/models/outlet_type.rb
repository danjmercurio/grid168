class OutletType < ActiveRecord::Base
  has_many :outlets

  attr_accessible :name
end
